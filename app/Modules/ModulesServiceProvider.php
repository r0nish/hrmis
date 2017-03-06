<?php namespace Modules;

/**
 * ServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 */

class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * Will make sure that the required modules have been fully loaded
	 * @return void
	 */
	public function boot()
	{
		// For each of the registered modules, include their routes and Views
		$modules = config("module.modules");

		while (list(, $module) = each($modules)) {

			if (is_array($module)) {

				$moduleName = key($module);

				while (list(, $subModule) = each($module)) {

					if (is_array($subModule)) {
						while (list(, $childModule) = each($subModule)) {
							if (file_exists(__DIR__ . '/' . $moduleName . '/' . $childModule . '/routes.php')) {
								require __DIR__ . '/' . $moduleName . '/' . $childModule . '/routes.php';
							}
						}
					}
				}
			}
			else {
				// Load the routes for each of the modules
				if (file_exists(__DIR__ . '/' . $module . '/Http/routes.php')) {
					require __DIR__ . '/' . $module . '/Http/routes.php';
				}
				// If there are any sub modules within the modules
			}
		}
	}

	public function register()
	{
	}

}
