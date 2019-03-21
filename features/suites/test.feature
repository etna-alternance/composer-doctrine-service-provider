# language: fr
Fonctionnalité: Je test mon bundle

Scénario: on test une simple requête sur notre api de test
    Etant donné que j'ai le droit de faire 0 requetes SQL
    Quand           je fais un GET sur /product
    Alors           ca ne devrait pas s'être bien déroulé
    Et              l'exception devrait avoir comme message "Too many SQL queries (1)"

Scénario: on test une simple requête sur notre api de test
    Quand           je fais un GET sur /product
    Alors           ca devrait s'être bien déroulé
