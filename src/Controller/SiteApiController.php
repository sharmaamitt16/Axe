<?php
/**
 * @file
 */

namespace Drupal\axe\Controller;

use Drupal\Core\Controller\ControllerBase;
use function GuzzleHttp\json_encode;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SiteApiController
 * @package Drupal\axe\Controller
 */
class SiteApiController extends ControllerBase {

  /**
   * Return json representation of data of node of type page on api call.
   *
   * @param string $apikey
   * @param int $nid
   *
   * @return object $response
   */
  function apiCallAction($apikey, $nid) {
    $error_flag = 0;
    $output = NULL;

    if (!empty($apikey) && !empty($nid) && is_numeric($nid)) {
      $site_api_key = $this->config('system.site')->get('siteapikey');

      // Check if provided api key is equal to saved key.
      if ($site_api_key === $apikey) {
        // Load node of page type.
        $entities = $this->entityTypeManager()->getStorage('node')->loadByProperties([
          'type' => 'page',
          'nid' => $nid,
        ]);

        if (!empty($entities)) {
          // Preapre output to send in response
          foreach ($entities as $entity){
            $output = [
              'nid' => $nid,
              'title' => $entity->get('title')->getString(),
              'body' => $entity->get('body')->getString(),
            ];
          }
        }
        else {
          // Entity node doesn't exists.
          $error_flag = 1;
        }
      }
      else {
        // API Key is not matched.
        $error_flag = 1;
      }
    }
    else {
      // Parameter are not passed as required in path.
      $error_flag = 1;
    }

    // In case of any error return access_denied(403) exception.
    if ($error_flag == 1) {
      $response = new Response('', Response::HTTP_FORBIDDEN);
      return $response;
    }

    // Return json encoded node data.
    if (isset($output)) {
      $response = new Response();
      $response->setContent(json_encode($output));
      return $response;
    }
  }

}
