<?php

namespace Drupal\site_alter\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Component\Serialization\Json;
use Symfony\Component\Serializer\SerializerInterFace;
use Symfony\Component\HttpFoundation\Response;

Class NodeJsonController extends ControllerBase {

	public function loadNodeJson($site_api_key, $nid) {

		if($site_api_key == \Drupal::config('site_api_key.settings')->get('site_api_key') && !empty($nid)) 
		{

			$node = Node::load($nid);

			if($node->bundle() == "page") {
				$serializer = \Drupal::service('serializer');

				/* Serialize and converting node data into json */
				$json_output = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
				
				return new Response($json_output);
			}
			else {
				throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();	
			}
 	
		}

		else {
			
			throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();

		}

	}
}
