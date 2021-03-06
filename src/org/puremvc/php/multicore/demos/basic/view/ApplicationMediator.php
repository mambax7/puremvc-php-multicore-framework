<?php
namespace puremvc\php\multicore\demos\basic\view;
use puremvc\php\multicore\interfaces\INotification;
use puremvc\php\multicore\patterns\mediator\Mediator;
use puremvc\php\multicore\demos\basic\ApplicationFacade;
use puremvc\php\multicore\demos\basic\view;
/**
 * PureMVC PHP Basic Demo
 * @author Omar Gonzalez :: omar@almerblank.com
 * @author Hasan Otuome :: hasan@almerblank.com
 *
 * Created on Sep 24, 2008
 * PureMVC - Copyright(c) 2006-2008 Futurescale, Inc., Some rights reserved.
 * Your reuse is governed by the Creative Commons Attribution 3.0 Unported License
 */

/**
 * The ApplicationMediator updates the display of the view
 * when data is ready to be displayed.
 */
class ApplicationMediator extends Mediator
{
    const NAME = 'ApplicationMediator';

    /**
     * Constructor
     * @param mixed $view
     */
    public function __construct($view)
    {
        parent::__construct(self::NAME, $view);
    }

    /**
     * Lists the notifications that this mediator is interested in.
     * VIEW_DATA_READY is sent by the ApplicationDataProxy when it is
     * done loading data.
     */
    public function listNotificationInterests()
    {
        return [ApplicationFacade::VIEW_DATA_READY];
    }

    /**
     * Handles notifications sent by the PureMVC framework that this
     * Mediator is interested in.
     * @param INotification $notification
     */
    public function handleNotification(INotification $notification)
    {
        switch ($notification->getName()) {
            case ApplicationFacade::VIEW_DATA_READY:
                $this->_printDisplay($notification);
                break;
            default:
                break;
        }
    }

    /**
     * Prints the view to the browser when the VIEW_DATA_READY
     * notification is sent.
     * @param INotification $notification
     */
    private function _printDisplay(INotification $notification)
    {
        $viewData = $notification->getBody();

        $css = $viewData['css'];

        $template = $this->getApplicationView()->getViewTemplate();

        $output = str_replace('{css}', $css, $template);

        print($output);
    }

    /**
     * Public getter for the view class instance.
     *
     * @return View\ApplicationView object.
     */
    public function getApplicationView()
    {
        return $this->getViewComponent();
    }
}
