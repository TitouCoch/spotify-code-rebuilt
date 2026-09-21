# Spotify Code Rebuilt

**Scannable "sound-wave" codes like Spotify Codes, rebuilt from scratch and decoded from a webcam in the browser using classic computer vision.**

![Demo: generating a code, then scanning it from a phone screen](assets/demo.gif)

## Why

[Spotify Codes](https://boonepeter.github.io/posts/2020-11-10-spotify-codes/) show that a row of bars of different heights can replace a QR code and look much better. The format is described in Spotify's patents (EP 3444755, US 2018/0181849), but no implementation is published.


- **Barcode format, based on Spotify Codes.** An ID of 10 alphanumeric characters becomes 20 bars with 8 possible heights, drawn next to a logo whose size gives the scanner a reference height. Spotify's own codes also carry 20 bars of data.
- **Scanner that runs entirely in the browser.** OpenCV.js (WebAssembly) finds the bars in the webcam feed and corrects for rotation, using deterministic image processing only. The decoded ID is then checked against a database through a small PHP API.
- **Prototype ports in C++ and Python** of the bar-height extraction step.

## How it works

**Encoding**: the example follows the character `A` through each step.

```mermaid
flowchart LR
    A(["<b>ID</b><br/>10 characters"])
    B["<b>Gray code</b><br/>6 bits per char"]
    C["<b>Split</b><br/>3-bit groups"]
    D["<b>Bar heights</b><br/>1 to 8"]
    E(["<b>Code</b><br/>logo + 20 bars"])

    A -- "A" --> B -- "010111" --> C -- "010 · 111" --> D -- "8 · 4" --> E

    classDef io fill:#1E293B,stroke:#1E293B,color:#FFFFFF,stroke-width:1.5px
    classDef step fill:#F8FAFC,stroke:#94A3B8,color:#0F172A,stroke-width:1.5px
    class A,E io
    class B,C,D step
    linkStyle default stroke:#64748B,stroke-width:1.5px
```

**Decoding**

```mermaid
flowchart LR
    subgraph CAPTURE ["Capture"]
        direction TB
        A(["Webcam frame"]) --> B["Crop + grayscale"]
    end
    subgraph VISION ["Computer vision · OpenCV.js"]
        direction TB
        C["Canny edges<br/>+ contours"] --> D["Rotation correction<br/>+ object filtering"]
    end
    subgraph DECODE ["Decode"]
        direction TB
        E["Height ratios<br/>vs. logo"] --> F["Gray code"] --> G(["ID"])
    end
    H[("API check<br/>MySQL")]

    CAPTURE --> VISION --> DECODE --> H

    classDef io fill:#1E293B,stroke:#1E293B,color:#FFFFFF,stroke-width:1.5px
    classDef step fill:#F8FAFC,stroke:#94A3B8,color:#0F172A,stroke-width:1.5px
    classDef db fill:#E2E8F0,stroke:#475569,color:#0F172A,stroke-width:1.5px
    class A,G io
    class B,C,D,E,F step
    class H db
    style CAPTURE fill:transparent,stroke:#94A3B8,stroke-dasharray:4 4
    style VISION fill:transparent,stroke:#94A3B8,stroke-dasharray:4 4
    style DECODE fill:transparent,stroke:#94A3B8,stroke-dasharray:4 4
    linkStyle default stroke:#64748B,stroke-width:1.5px
```

As in Spotify's design, the bars use **Gray code**: two neighboring heights differ by only one bit. If a bar is misread as the next height up or down, only one bit of the result is wrong. Spotify also adds a CRC and forward error correction, which are the next step for this project.
