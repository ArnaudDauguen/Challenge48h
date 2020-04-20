# <p align="center"> 🛒 **CoCourses** 🛒

## <p align="center">**Challenge 48h** 
#### <p align="center"> **Dauguen Arnaud - Duart Quentin - Flores Anthony - Sella Justin**

## **PROJET**

### **Contexte**

Les personnes ne pouvant pas faire leurs courses seules se retrouvent sans aucune possibilité aujourd'hui.

Le projet consiste à réaliser une API de course participative. (des clients - un livreur)
Les utilisateurs font leurs listes de courses de ce qu'il veulent (ils définissent une plage de livraison).

Un utilisateur peut se proposer livreur et définit le nombre de courses à prendre maximum et prend les 'n' premières qui ont été réalisées.
Les courses réalisées et faites, il récupère 1es tickets de caisses et les upload sur l'app pour obtenir un remboursement de chaque livraison via Paypal.

### **Architecture du projet**

![Architecture](/readme_folder/images/archi.png "Architecture")

### **Description des données**

![BDD](/readme_folder/images/bdd.png "BDD")

### **Fonctionnalités majeures**

Communes

- Création de compte
- Création d'une liste de course

Utilisateurs

- Ajout des information au panier
- Validation du panier
- Payer le livreur apres livraison (Paypal)

Livreurs

- Définir son départ quand on est livreur
- Upload des reçus pour être payé
- Livrer les clients

### **Description du code**

Nous utilisons le language **php** pour produire des pages Web dynamiques. **Mysql** pour gérer la  base de données. Puis nous utilisons le **framework Symfony**. Il fournit des fonctionnalités modulables et adaptables qui permettent de faciliter et d’accélérer le développement d'un site web.

### **Plateforme matérielle**

Un serveur web et un serveur base de données pour le moment. Note : nous pouvons prévoir deux serveurs web dans quelques mois, quand le trafic sera plus élevé, avec un load balancer.


## **Evaluation budgétaire**

Onglet gantt
https://docs.google.com/spreadsheets/d/1xpiJ3AvW5l4EnjRoyrckZkVDSRcZWYOkEhNTe0-ypkU/edit?usp=sharing

## Diagramme de GANTT

Onglet Budget
https://docs.google.com/spreadsheets/d/1xpiJ3AvW5l4EnjRoyrckZkVDSRcZWYOkEhNTe0-ypkU/edit?usp=sharing


## **Lancement**

Installer les dépendences : ```cd app && npm install```

Lancer le server : ```npm start```

Lancer le l'api :  ```node main.js```