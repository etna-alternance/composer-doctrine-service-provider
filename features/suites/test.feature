# language: fr
Fonctionnalité: Je test mon bundle

Scénario: on test une simple requête sur notre api de test
    Etant donné que j'ai le droit de faire 0 requetes SQL
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200

Scénario: on test une simple requête sur notre api de test
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200

Scénario: on test une simple requête sur notre api de test
    Etant donné que j'ai le droit de faire 2 requetes SQL
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200

Scénario: on test une simple requête sur notre api de test
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200

Scénario: on test une simple requête sur notre api de test
    Etant donné que j'ai le droit de faire 3 requetes SQL
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200

Scénario: on test une simple requête sur notre api de test
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200

Scénario: on test une simple requête sur notre api de test
    Etant donné que j'ai le droit de faire 10 requetes SQL
    Quand           je fais un GET sur /product
    Alors           le status HTTP devrait être 200
