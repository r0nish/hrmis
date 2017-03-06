<?php
	/**
	 * Created by PhpStorm.
	 * User: udnbikesh
	 * Date: 10/27/16
	 * Time: 9:14 PM
	 */

	namespace Modules\Foundation\Aspects;


	use Go\Core\AspectContainer;
	use Go\Core\AspectKernel;
	use Modules\ReportAspects\ApiLogAspect;
	use Modules\ReportAspects\PSKUAspect;
	use Modules\ReportAspects\SBDReportAspect;

	class ApplicationAspectKernel extends AspectKernel
	{

		/**
		 * Configure an AspectContainer with advisors, aspects and pointcuts
		 *
		 * @param AspectContainer $container
		 *
		 * @return void
		 */
		protected function configureAop(AspectContainer $container)
		{
			// TODO: Implement configureAop() method.

			$container->registerAspect(new SBDReportAspect());
			$container->registerAspect(new ApiLogAspect());
			$container->registerAspect(new PSKUAspect());

		}
	}