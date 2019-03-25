<?php

namespace App\Command;


use App\Domain\Report\Report;
use App\Domain\Report\ValidationResults;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\DataProviders;
use App\Utils\NotificationsBuilder;
use App\Utils\ReportBuilder;
use App\Utils\ReportPresenter;
use App\Utils\Senders\EmailSender;
use App\Utils\Senders\SmsSender;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Url as ConstraintUrl;


class WebBenchmarkCommand extends Command
{
    private static $defaultReportOptions = 'name,loadtime,loadtimediff';
    private static $defaultNotificationOptions = 'slowloadtime,doubleslowloadtime';

    protected static $defaultName = 'app:web-benchmark';

    protected function configure(): void
    {
        $this
            ->setDescription('Compare loading speed of given websites')
            ->addArgument('phone', InputArgument::REQUIRED, 'Phone number for notifications')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address for notifications')
            ->addArgument('url', InputArgument::REQUIRED, 'Main website')
            ->addArgument('compare', InputArgument::IS_ARRAY, 'Compare to websites (separate multiple names with a space)')
            ->addOption('reportOptions', 'r', InputOption::VALUE_REQUIRED, 'Set report options (separate multiple names with a ,)', self::$defaultReportOptions)
            ->addOption('notificationsOptions', 't', InputOption::VALUE_REQUIRED, 'Set notification options (separate multiple names with a ,)', self::$defaultNotificationOptions)

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $phone = $input->getArgument('phone');
        $email = $input->getArgument('email');
        $compare = $input->getArgument('compare');
        $reportOptions = $input->getOption('reportOptions');
        $notificationsOptions = $input->getOption('notificationsOptions');

        $validationResult = $this->validateURLs(array_merge([$url], $compare));

        if (!$validationResult->isEmpty()) {
            $report = new Report();
            $report->addElement($validationResult);
            $output->writeln('Invalid URLs given');
        } else {
            $reference = new Url($url);
            $compareTo = new Urls(array_map(function ($element) {return new Url($element);}, $compare));

            $dataProviders = new DataProviders();

            /**
             * Report
             */
            $reportBuilder = new ReportBuilder($dataProviders);
            $report = $reportBuilder->run(explode(',', $reportOptions), $reference, $compareTo);

            /**
             * Notification
             */
            $emailSender = new EmailSender($email);
            $smsSender = new SmsSender($phone);
            $notificationsBuilder = new NotificationsBuilder($dataProviders, $emailSender, $smsSender);
            $notificationsBuilder->notify(explode(',', $notificationsOptions), $reference, $compareTo);


        }

        $logger = new Logger('output');
        $logger->pushHandler(new StreamHandler('./out.txt'));

        $reportPresenter = new ReportPresenter($output, $logger);
        $reportPresenter->present($report);

    }




    private function validateURLs($urls): ValidationResults
    {

        $result = new ValidationResults();
        $validator = Validation::createValidator();

        foreach ($urls as $url) {
            $violations = $validator->validate($url, [
                new ConstraintUrl()
            ]);

            if (0 !== count($violations)) {
                $result->addResult($url, $violations[0]->getMessage());
            }
        }

        return $result;
    }
}