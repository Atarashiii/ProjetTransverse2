# Infrastructure
## Sécurité
- Firewall : PFsens.
- Point d'entree à l'infra permettant la sécurisation.

## Serveurs WEB
- Serveur PREPROD : Heberge l'application testé avant la mise en production.
- Serveur SRV-WEB01: héberge l'application web.
- Serveur SRV-WEB02: héberge l'application web (permet une redondance de l'application web).
- Serveur SRV-WEBHA : HA dispatche les requetes entre serv 1 et serv 2 ( le point d'entree de l'infra vers le site web).

## Base de données
- Type: MySQL
- Réplication : bdd en actif/actif
- Serveur SRV-BDD01: héberge la bdd 1.
- Serveur SRV-BDD02: héberge la bdd 2.
- Serveur SRV-BDDHA : HA dispatche les requetes entre serv 1 et serv 2 (permet la redondance de la bdd).


## Monitoring
- Outil: Uptime Kuma
- Description: Monitorage de l'application et notifications en cas d'incident.
