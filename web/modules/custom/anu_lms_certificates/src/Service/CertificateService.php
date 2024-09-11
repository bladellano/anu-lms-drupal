<?php

namespace Drupal\anu_lms_certificates\Service;

use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\node\NodeInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\anu_lms_certificates\Service\PdfGeneratorService;

/**
 * Class CertificateService.
 *
 * Service responsible for managing the creation and handling of certificates.
 */
class CertificateService {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The PDF generation service.
   *
   * @var \Drupal\anu_lms_certificates\Service\PdfGeneratorService
   */
  protected $pdfGeneratorService;

  /**
   * The folder where certificates are stored.
   */
  protected const FOLDER = 'private://certificados/';

  /**
   * CertificateService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   * @param \Drupal\anu_lms_certificates\Service\PdfGeneratorService $pdf_generator_service
   *   The PDF generation service.
   */
  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
    PdfGeneratorService $pdf_generator_service
  ) {
    $this->entityTypeManager = $entityTypeManager;
    $this->pdfGeneratorService = $pdf_generator_service;
  }

  /**
   * Creates a paragraph entity to store certificate data for the user.
   *
   * This method creates a "certificate" paragraph with the course name,
   * completion date, and a link to view the certificate. The paragraph is
   * appended to the user's "field_certificates" field.
   *
   * @param string $course_name
   *   The name of the completed course.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current user's account, used to load the user entity.
   * @param string $uri
   *   The URI of the certificate link.
   *
   * @return void
   */
  public function createParagraphEntity(string $course_name, AccountProxyInterface $account, string $uri): void {
    // Load the user entity.
    $user = User::load($account->id());

    $field_completion_date = DrupalDateTime::createFromTimestamp(time())->format('Y-m-d\TH:i:s');

    $paragraph = $this->entityTypeManager->getStorage('paragraph')->create([
      'type' => 'certificate',
      'field_course_name' => $course_name,
      'field_completion_date' => $field_completion_date,
      'field_certificate_link' => [
        'uri' => $uri,
        'title' => 'View Certificate',
        'options' => ['attributes' => ['target' => '_blank']],
      ],
    ]);

    $paragraph->save();
    $user->field_certificates->appendItem($paragraph);
    $user->save();
  }

  /**
   * Creates a PDF certificate for a course completion.
   *
   * This method generates a PDF certificate for the user upon course completion
   * and returns the URI for accessing the certificate.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The user account for whom the certificate is created.
   * @param \Drupal\node\NodeInterface $course
   *   The course node.
   * @param int|null $lesson_id
   *   The lesson ID associated with the completion (optional).
   *
   * @return string
   *   The URI to access the generated certificate.
   */
  public function createCertificateCourse(AccountProxyInterface $account, NodeInterface $course, int $lesson_id = NULL): string {
    $title = 'Completion Certificate - ' . $account->getDisplayName();
    $hash = substr(md5(time() . random_bytes(5)), 0, 8);
    $file_name = 'certificate-' . $course->id() . '-' . $account->id() . '_' . $hash . '.pdf';
    $file_path = self::FOLDER . $file_name;

    $uri = Url::fromRoute('anu_lms_certificates.pdf_download', ['file_name' => $file_name, 'user' => $account->id()])->toString();

    $content = [
      '#markup' => '<h1>Completion Certificate</h1><p>Congratulations, ' . $account->getDisplayName() . ', you have completed course ' . $course->id() . '.</p>',
    ];

    $this->pdfGeneratorService->generatePdf($title, $content, $file_path);

    return $uri;
  }

  /**
   * Checks if the user has completed the entire course.
   *
   * @param array $progress
   *   The course progress data.
   *
   * @return bool
   *   TRUE if the course is fully completed, FALSE otherwise.
   */
  public function isCourseCompleted(array $progress): bool {
    foreach ($progress as $prog) {
      if ($prog['completed'] !== 1) {
        return false;
      }
    }
    return true;
  }

}
