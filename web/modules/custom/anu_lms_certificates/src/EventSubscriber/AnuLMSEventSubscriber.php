<?php

namespace Drupal\anu_lms_certificates\EventSubscriber;

use Drupal\anu_lms\Lesson;
use Drupal\anu_lms\CourseProgress;
use Drupal\anu_lms\Event\LessonCompletedEvent;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\anu_lms_certificates\Service\CertificateService;

/**
 * Class AnuLMSEventSubscriber.
 *
 * Subscribes to ANU LMS lesson completion events to handle certificate generation.
 */
class AnuLMSEventSubscriber implements EventSubscriberInterface {

  /**
   * The logger factory service.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * The lesson service.
   *
   * @var \Drupal\anu_lms\Lesson
   */
  protected $lessonService;

  /**
   * The course progress service.
   *
   * @var \Drupal\anu_lms\CourseProgress
   */
  protected $courseProgressService;

  /**
   * The certificate service.
   *
   * @var \Drupal\anu_lms_certificates\Service\CertificateService
   */
  protected $certificateService;

  /**
   * Constructs the event subscriber.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger factory service.
   * @param \Drupal\anu_lms\Lesson $lesson_service
   *   The lesson service.
   * @param \Drupal\anu_lms_certificates\Service\CertificateService $certificate_service
   *   The certificate generation service.
   * @param \Drupal\anu_lms\CourseProgress $course_progress
   *   The course progress service.
   */
  public function __construct(
    LoggerChannelFactoryInterface $logger_factory,
    Lesson $lesson_service,
    CertificateService $certificate_service,
    CourseProgress $course_progress
  ) {
    $this->loggerFactory = $logger_factory;
    $this->lessonService = $lesson_service;
    $this->certificateService = $certificate_service;
    $this->courseProgressService = $course_progress;
  }

  /**
   * Handles the LessonCompletedEvent.
   *
   * This method is triggered when a lesson is completed. It checks if the
   * user has completed the course and, if so, generates a certificate and
   * logs the event.
   *
   * @param \Drupal\anu_lms\Event\LessonCompletedEvent $event
   *   The event object containing lesson and user data.
   *
   * @return void
   */
  public function onLessonCompleted(LessonCompletedEvent $event): void {

    $account = $event->getAccount();
    $lesson_id = $event->getLessonId();

    #$module_lesson = $this->lessonService->getLessonModule($lesson_id);

    // Get the course associated with the lesson.
    $course = $this->lessonService->getLessonCourse($lesson_id);

    // Get the course name.
    $course_name = reset($course->title->getValue()[0]);

    $logger = $this->loggerFactory->get('anu_lms_certificates');

    // Get the course progress for the user.
    $progress = $this->courseProgressService->getCourseProgress($course);

    // Check if the user has completed the course.
    if ($this->certificateService->isCourseCompleted($progress)) {
      // Generate a certificate and store its URI.
      $uri = $this->certificateService->createCertificateCourse($account, $course, $lesson_id);

      $this->certificateService->createParagraphEntity($course_name, $account, $uri);

      $logger->notice('A certificate was generated for @username', ['@username' => $account->getDisplayName()]);
    }
  }

  /**
   * Registers the events to subscribe to.
   *
   * @return array
   *   An array of event names and their corresponding handler methods.
   */
  public static function getSubscribedEvents() {
    return [
      LessonCompletedEvent::EVENT_NAME => 'onLessonCompleted',
    ];
  }

}
