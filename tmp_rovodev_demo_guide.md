# 🔍 GUIDE DE DÉMONSTRATION - WOODSHOP PRO

## 🚀 POUR VOIR VOTRE E-COMMERCE EN ACTION

### 1. INSTALLATION ET SETUP

```bash
# Installer les dépendances
composer install
npm install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Base de données
touch database/database.sqlite  # Si SQLite
php artisan migrate
php artisan db:seed  # Charge les données d'exemple

# Lancer le serveur
npm run dev &  # En arrière-plan
php artisan serve  # http://localhost:8000
```

### 2. CE QUE VOUS POUVEZ TESTER

#### 🏠 **PAGE D'ACCUEIL** (`http://localhost:8000`)
- Catalogue avec 6 produits d'exemple
- Filtres par essence de bois (Chêne, Hêtre, Fruitiers)
- Filtres par usage (Chauffage, Cuisson)
- Recherche par mot-clé

#### 🛍️ **FONCTIONNALITÉS CATALOGUE**
- **Filtres avancés** : Prix, stock, conditionnement
- **Tri** : Nom, prix, stock
- **Pagination** automatique
- **Design responsive** mobile/desktop

#### 📦 **FICHES PRODUITS DÉTAILLÉES**
- Caractéristiques spécialisées bois (humidité, essence)
- Calcul automatique quantité/prix
- Photos et descriptions complètes
- Conseils d'utilisation
- Produits similaires

#### 🛒 **PANIER INTELLIGENT**
- Ajout avec vérification stock/quantités minimum
- Différenciation prix particulier/professionnel
- Calcul temps réel
- Persistance session

#### 🚚 **CALCUL LIVRAISON**
- Saisie code postal → prix instantané
- 5 zones configurées (Paris, IDF, Nord, Rhône-Alpes, PACA)
- Seuils de livraison gratuite
- Estimation délais

### 3. DONNÉES D'EXEMPLE CRÉÉES

#### **Catégories** :
- Bois de Chauffage
- Bois de Cuisson  
- Professionnels

#### **Produits** :
- Chêne sec stère 85€ (chauffage)
- Hêtre sacs 40kg 8,50€ (chauffage)
- Mélange feuillus palette 110€
- Bois fruitiers barbecue 12,90€ (cuisson)
- Chêne four pizza 95€ (cuisson)
- Big bag pro 1000kg 320€ (professionnel uniquement)

#### **Zones de livraison** :
- Paris : 25€ (gratuit > 150€)
- IDF : 45€ (gratuit > 200€)
- Nord : 65€ (gratuit > 250€)
- Rhône-Alpes : 75€ (gratuit > 300€)
- PACA : 85€ (gratuit > 350€)

#### **Comptes utilisateurs** :
- `client@woodshop.fr` (particulier)
- `pro@restaurant.fr` (professionnel - voit prix réduits)

### 4. URLS À TESTER

```
/ ou /catalogue        → Catalogue principal
/produit/[slug]        → Fiche produit
/panier               → Panier d'achat
/recherche?q=chene    → Recherche
```

### 5. APIS DISPONIBLES

```
POST /panier/add/{product}     → Ajouter au panier
PUT /panier/update/{item}      → Modifier quantité  
DELETE /panier/remove/{item}   → Supprimer item
POST /livraison/calculate      → Calculer livraison
```

### 6. POINTS FORTS À OBSERVER

✅ **UX Optimisée** : Navigation fluide, filtres intuitifs
✅ **Métier Spécialisé** : Vocabulaire bois, caractéristiques techniques
✅ **Prix Intelligents** : Différenciation particulier/pro automatique
✅ **Stock Temps Réel** : Vérifications automatiques
✅ **SEO Ready** : URLs, meta, structure optimisée
✅ **Mobile First** : Responsive parfait
✅ **Performance** : Requêtes optimisées, cache

## 🎯 VOILÀ CE QUI EST FONCTIONNEL !

Votre e-commerce est prêt à recevoir de vrais clients et commandes !