/**
 * Objet Liste Ratios
 * @class ListeRatios
 * @property {Array.<number>} ListeRatios - La liste des ratios
 * @author Sport Track
 */
class ListeRatios {
    /**
     * Constructeur de l'objet ListeRatios.
     *
     * @param {Array.<number>} uneListeRatios - Liste de ratios.
     */
    constructor(uneListeRatios) {
        this.ListeRatios = uneListeRatios;

    };
    /**
     * Méthode getListeRatios pour définir l'attribut de l'objet 
     * @function
     * @param {Array.<number>} uneListeRatios - Une liste de ratios
     */
    setListeRatios(uneListeRatios) {
        this.ListeRatios = uneListeRatios;
    };
    /**
     * Méthode getListeRatios pour récupérer l'attribut de l'objet 
     * @function
     * @returns {Array.<number>}
     */
    getListeRatios() {
        return this.ListeRatios;
    };

};