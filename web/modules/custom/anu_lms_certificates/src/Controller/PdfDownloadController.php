<?php

namespace Drupal\anu_lms_certificates\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PdfDownloadController.
 *
 * Controller for handling PDF file downloads.
 */
class PdfDownloadController extends ControllerBase {

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * Constructs a new PdfDownloadController object.
   *
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   */
  public function __construct(FileSystemInterface $file_system) {
    $this->fileSystem = $file_system;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_system')
    );
  }

  /**
   * Handles downloading a PDF file.
   *
   * This method retrieves a PDF file from the private file system based on the
   * provided file name and returns it as a downloadable response. If the file
   * is not found, it throws a 404 exception.
   *
   * @param string $file_name
   *   The name of the file to download.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response containing the PDF file for download.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   Thrown when the file is not found.
   */
  public function download($file_name) {
    $file_path = 'private://certificados/' . $file_name;

    if (file_exists($file_path)) {
      $file_contents = file_get_contents($file_path);

      $response = new Response($file_contents);

      $response->headers->set('Content-Type', 'application/pdf');
      $response->headers->set('Content-Disposition', 'attachment; filename="' . $file_name . '"');

      return $response;
    }

    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
  }

}
