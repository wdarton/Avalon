<?php
declare( strict_types = 1 );

namespace Avalon\Middleware\UnauthorizedHandler;

use Authorization\Exception\Exception;
use Authorization\Middleware\UnauthorizedHandler\RedirectHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Log\Log;

class CustomRedirectHandler extends RedirectHandler {
    public function handle( Exception $exception, ServerRequestInterface $request, array $options = [] ): ResponseInterface 
    {
        if (is_null($request->getAttribute('identity'))) {
            $msg = 'You are not logged in.';
        } else {
            $msg = 'You are not authorized to access that location or perform that action.';
        }

        // $options['url'] = $request->getAttribute('params');
        // Log::debug(__FILE__.' '.__LINE__);
        // Log::debug('FINDME');
        // Log::debug(print_r($request->getAttribute('params'), true));
        // Log::debug(print_r($request->getAttribute('here'), true));
        // Log::debug(print_r($request->getUri(), true));

        $response = parent::handle( $exception, $request, $options );
        $request->getFlash()->error( $msg );
        if ($request->getAttribute('params')['action'] == 'logout') {
            return $response;
        }
        // $response->redirect($request->referer());
        // $this->referer();
        // $this->redirect('/dashboard');
        // $this->getUrl($request, $options);
        return $response;
    }
}