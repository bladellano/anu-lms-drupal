<?php

namespace Drupal\anu_lms_certificates\Service;

use Drupal\pdf_generator\DompdfGenerator;
use Drupal\Core\File\FileSystemInterface;

/**
 * Class PdfGeneratorService.
 *
 * Service for generating personalized PDFs for certificates.
 */
class PdfGeneratorService {

  /**
   * The DompdfGenerator service for PDF creation.
   *
   * @var \Drupal\pdf_generator\DompdfGenerator
   */
  protected $dompdfGenerator;

  /**
   * The FileSystem service for file manipulation.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * Constructs the PdfGeneratorService.
   *
   * @param \Drupal\pdf_generator\DompdfGenerator $dompdfGenerator
   *   The PDF generation service.
   * @param \Drupal\Core\File\FileSystemInterface $fileSystem
   *   The file system service used for saving files.
   */
  public function __construct(DompdfGenerator $dompdfGenerator, FileSystemInterface $fileSystem) {
    $this->dompdfGenerator = $dompdfGenerator;
    $this->fileSystem = $fileSystem;
  }

  /**
   * Generates a PDF based on the provided content and saves it to the specified path.
   *
   * @param string $title
   *   The title of the PDF document.
   * @param array $content
   *   The render array containing the content to be included in the PDF.
   * @param string $file_path
   *   The path where the generated PDF will be saved.
   *
   * @return string
   *   The full path of the saved PDF file.
   */
  public function generatePdf(string $title, array $content, string $file_path): string {
    // Generate the PDF response from the content using the DompdfGenerator service.
    $response = $this->dompdfGenerator->getResponse($title, $content, FALSE, [], 'A4', 'landscape', NULL, NULL, FALSE);

    $this->fileSystem->saveData($response->getContent(), $file_path, FileSystemInterface::EXISTS_REPLACE);

    return $file_path;
  }
}
