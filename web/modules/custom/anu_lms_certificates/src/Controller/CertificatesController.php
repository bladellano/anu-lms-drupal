<?php

namespace Drupal\anu_lms_certificates\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CertificatesController.
 *
 * Controller for managing and displaying the user's certificates.
 */
class CertificatesController extends ControllerBase {

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a new CertificatesController object.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user service.
   */
  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * Renders the certificates page for the current user.
   *
   * This method loads the certificates associated with the current user,
   * sorts them by their completion date, and prepares a render array for
   * displaying in a theme template.
   *
   * @return array
   *   A render array representing the certificates page.
   */
  public function viewCertificates() {

    $account = $this->currentUser;

    $current_user = User::load($account->id());

    $certificates = $current_user->get('field_certificates')->referencedEntities();

    $build = [
      '#theme' => 'certificates_list',
      '#certificates' => [],
    ];

    // Sort certificates by completion date, newest first.
    usort($certificates, function ($a, $b) {
      return strtotime($b->get('field_completion_date')->value) - strtotime($a->get('field_completion_date')->value);
    });

    foreach ($certificates as $certificate) {
      $build['#certificates'][] = [
        'course_name' => $certificate->get('field_course_name')->value,
        'completion_date' => $certificate->get('field_completion_date')->value,
        'certificate_link' => $certificate->get('field_certificate_link')->uri,
        'certificate_link_title' => $certificate->get('field_certificate_link')->title,
      ];
    }

    return $build;
  }

}
