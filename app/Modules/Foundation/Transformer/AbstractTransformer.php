<?php

	namespace App\Modules\Foundation\Transformer;


	abstract class AbstractTransformer
	{
		/**
		 * @param $items ( Collection  ORM Object.)
		 *
		 * @return array
		 *
		 */

		public function transformCollection($items, $nonHierarchyStatus = false)
		{
			//return array_map([$this, 'transform'], $items);

			if (!$items) {
				return $items;
			}
			$collectionArray = [];

			/**
			 * Get the permission data according to collection and send
			 * the permission to the transformer.
			 */

			// Dynamically choose the transform method
			$transform = 'transform';
			if ($nonHierarchyStatus) {
				$transform = 'transformNonHierarchy';
			}

			foreach ($items as $item) {
				$collectionArray[] = $this->$transform($item);
			}

			return $collectionArray;
		}

		/**
		 * Common date format for response
		 *
		 * @param $date
		 *
		 * @return bool|string
		 */
		public function formatDate($date)
		{
			return date("M d, Y h:s", strtotime($date));
		}

		abstract public function transform($item);

		public function transformNonHierarchy($item) { }

	}
