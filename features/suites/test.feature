# language: fr
Fonctionnalité: Je test mon bundle


Scénario: On test que le service est bien présent
    Etant donné que je veux récupérer un service "debug_service"
    Alors       ca devrait s'être bien déroulé


Scénario: on test une requète sur notre api de test alors qu'on n'a pas le droit.
    Etant donné que j'ai le droit de faire 0 requetes SQL
    Quand           je fais un GET sur /product
    Alors           ca ne devrait pas s'être bien déroulé
    Et              l'exception devrait avoir comme message "Too many SQL queries (1)"

Scénario: on test une simple requête sur notre api de test sans restriction
    Quand           je fais un GET sur /product
    Alors           ca devrait s'être bien déroulé
