# STI - Projet 2 - Analyse de menaces

> Auteurs : Robin Gaudin - Lev Pozniakoff
>
> Date : 20.01.2022

## Introduction

Ce document fait office d'analyse de menace de l'état actuel de la sécurité de l'application Web du projet 1 de STI. Plusieurs éléments seront donc examinés pour déterminer quelles sont les menaces sur l'application, comment est-ce qu'elles pourraient être exploitées par un attaquant et qu'elles sont les contre-mesures à mettre en place.

Cette application Web est un système de messagerie pour une entreprise, permettant aux collaborateurs s'authentifiant auprès du service à l'aide d'un nom d'utilisateur et d'un mot de passe, de communiquer avec les autres collaborateurs en pouvant envoyer, lire, répondre ou supprimer des messages. Le mot de passe peut également être modifié par le collaborateur.

Un collaborateur dit administrateur aura les mêmes fonctionnalités qu'un collaborateur standard, avec en plus, une gestion des utilisateurs. En effet, il pourra ajouter, modifier ou supprimer les collaborateurs.

Cette application est donc contrainte à la sécurité, puisqu'un attaquant pourrait vouloir visualiser les messages d'autres collaborateurs, afin, par exemple, d'obtenir des informations sur l'entreprise ou sur les collaborateurs. Un collaborateur pourrait également se faire usurper son identité, ou certaines actions pourraient être exécutées sans que l'utilisateur ne soit au courant.

## Description du système

### Objectifs du système

- Les collaborateurs d'une entreprise doivent pouvoir s'envoyer des messages entre eux de manière sécurisée
- Les collaborateurs peuvent également lire, répondre et supprimer les messages qu'ils ont reçu
- Un rôle d'administrateur est attribué à certains des collaborateurs et pourront, en plus des fonctionnalités d'un collaborateur standard, ajouter, modifier ou supprimer d'autres collaborateurs

### Hypothèses de sécurité

- Les administrateurs doivent être de confiance, tant au niveau applicatif que sur le réseau
- Un serveur applicatif ainsi que le système d'exploitation de confiance

### Exigences de sécurité

Afin que l'application puisse être dite "sûre", elle doit satisfaire les critères suivants :

- Le nom d'utilisateur doit être unique (unicité)
- L'envoi, la lecture, la suppression et la réponse d'un message ne peut être faite que part un utilisateur connecté (authentification)
- La lecture, la suppression et la réponse à un message peut être faite uniquement par l'utilisateur qui a reçu le message (confidentialité)
- Le contenu du message ne doit pas pouvoir se faire modifier une fois qu'il a été envoyé (intégrité)
- Le mot de passe doit être modifiable uniquement par l'utilisateur connecté ou un administrateur (intégrité)
- Le rôle et la validité d'un utilisateur doit être modifiable  uniquement par un administrateur (intégrité)
- Les informations des utilisateurs doivent être protégées (privacy)
- Afin de se connecter, un utilisateur doit avoir un compte. Celui-ci doit être actif (contrôle d'accès)
- La gestion des utilisateurs (ajout, modification, suppression) doit être accessible que par les administrateurs (contrôle d'accès)
- Le site Web doit être disponible 99% du temps (disponibilité) 

### Eléments du système

- Base de données contenant les utilisateurs (nom d'utilisateur, mot de passe, validité, role) et les messages (id, date, envoyeur, receveur, sujet, message)
- Application Web

### Rôle des utilisateurs

- Utilisateur non-authentifié : Considéré comme un visiteur, il peut uniquement accéder à la page de login et peut se connecter afin de devenir un utilisateur authentifié
- Utilisateur authentifié : Collaborateur de l'entreprise qui s'est connecté
- Administrateur du site : Collaborateur de l'entreprise qui s'est connecté, ayant le rôle d'administrateur
- Administrateur système : Utilisateurs n'ayant pas de compte sur l'application Web, mais ayant accès aux machines qui hébergent l'application et la base de données

### Actifs à haute valeur

- Base de données
  - Confidentialité, sphère privée
  - Intégrité
  - Perte de réputation en cas d'incident
- Infrastructure
  - Intégrité, disponibilité
  - Perte de disponibilité, réputation en cas d'incident

### DFD

![](images/DFD.png)

### Périmètre de sécurisation

Dans le cadre de ce projet, uniquement l'application Web est prise en compte pour cette analyse de menaces.

## Identification des sources de menaces

## Identification des scénarios d'attaques

## Identification des contremesures

## Conclusion

