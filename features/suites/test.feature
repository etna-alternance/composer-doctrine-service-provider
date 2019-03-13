# language: fr
Fonctionnalité: Je test mon bundle

Scénario: on test une simple requête sur notre api de test
    Quand je fais un GET sur /product
    Alors le status HTTP devrait être 200
