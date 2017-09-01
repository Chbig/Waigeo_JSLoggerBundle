## Description
Ce bundle permet de logguer les erreurs JavaScript d'une application afin de les stocker dans une base de données coté serveur. Ensuite, vous pouvez consulter les erreurs JS depuis une interface tout en bénéficiant d'une recherche.
Les informations remontées sont :
*  Le message d'erreur
*  L'url de la page ou s'est produite l'erreur
*  La date à laquelle s'est produite l'erreur
*  Le navigateur utilisé

## Installation

1. `composer require waigeo/jsloggerbundle`

2. Enregistrer le bundle dans le AppKernel   
```php
public function registerBundles()
{
	$bundles = [
		...
		new Waigeo\JSLoggerBundle\WaigeoTaskManagerBundle(),
		...
	];

	return $bundles;
}
```

3. Importer les routes du bundle. Dans "app/config/routing.yml" ajouter le bloc suivant
```yml
waigeo_js_logger:
    resource: "@WaigeoJSLoggerBundle/Resources/config/routing.yml"
    prefix:   /   
```

4. Mettre à jour votre schéma de base de données en exécutant la commande  
`php bin/console doctrine:schema:update --dump-sql`  
puis  
`php bin/console doctrine:schema:update --force`

5. Exécuter l'installtion des assets en exécutant la commande
`php bin/console assets:install`

6. Inclure ces deux lignes de JavaScript dans la page ou vous souhaitez logguer les erreurs
`<script src="{{ asset('bundles/waigeojslogger/jsLoggerManager.js') }}"></script>
<script>
    jsLoggerManager.init('{{ path('jslogger_savelog') }}');
</script>`

## Utilisation
### Consultation des logs
Vous pouvez consulter les logs et les filtrer sur la page à l'addresse suivante :
http://{server}/{applicationName}/web/app_dev.php/jslogger/listpage





