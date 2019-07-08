<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request;
        $requestMethod = $canonicalMethod = $context->getMethod();
        $scheme = $context->getScheme();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }


        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === $trimmedPathinfo) {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($rawPathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler_open_file
                if ('/_profiler/open' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:openAction',  '_route' => '_profiler_open_file',);
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        elseif (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/account')) {
                // loginPage
                if ('/account/login' === $pathinfo) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'loginPage', key($requiredSchemes));
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::loginAction',  '_route' => 'loginPage',);
                }

                if (0 === strpos($pathinfo, '/account/register')) {
                    // registerPage
                    if ('/account/register' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'registerPage', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::registerAction',  '_route' => 'registerPage',);
                    }

                    // registerCheckEmail
                    if ('/account/register/check_email' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'registerCheckEmail', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::registerCheckEmail',  '_route' => 'registerCheckEmail',);
                    }

                    // registerErrors
                    if ('/account/register/errors' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'registerErrors', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::registerErrors',  '_route' => 'registerErrors',);
                    }

                }

                elseif (0 === strpos($pathinfo, '/account/reset')) {
                    // resetPasswordPage
                    if ('/account/reset' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'resetPasswordPage', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::resetPasswordAction',  '_route' => 'resetPasswordPage',);
                    }

                    // resetPasswordConfirmed
                    if ('/account/reset/confirmed' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'resetPasswordConfirmed', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::resetPasswordConfirmedAction',  '_route' => 'resetPasswordConfirmed',);
                    }

                }

                // forgotPasswordPage
                if ('/account/forgot' === $pathinfo) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'forgotPasswordPage', key($requiredSchemes));
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::forgotPasswordAction',  '_route' => 'forgotPasswordPage',);
                }

                if (0 === strpos($pathinfo, '/account/password/set')) {
                    // accountSetPassword
                    if ('/account/password/set' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'accountSetPassword', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::setPasswordAction',  '_route' => 'accountSetPassword',);
                    }

                    // accountSetPasswordCheck
                    if ('/account/password/set_check' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_accountSetPasswordCheck;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'accountSetPasswordCheck', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Web\\AccountController::setPasswordCheckAction',  '_route' => 'accountSetPasswordCheck',);
                    }
                    not_accountSetPasswordCheck:

                }

            }

            // usersPage
            if ('/admin/users' === $pathinfo) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'usersPage', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Web\\AdminController::usersAction',  '_route' => 'usersPage',);
            }

            if (0 === strpos($pathinfo, '/api')) {
                if (0 === strpos($pathinfo, '/api/billing')) {
                    // apiBillingSquareProcess
                    if ('/api/billing/square/process' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiBillingSquareProcess;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingSquareProcess', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::processPaymentAction',  '_route' => 'apiBillingSquareProcess',);
                    }
                    not_apiBillingSquareProcess:

                    // apiBillingCheckNearing
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)/payment$#s', $pathinfo, $matches)) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingCheckNearing', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingCheckNearing')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::checkIfNearingBillingAction',));
                    }

                    // apiBillingUpdatePayment
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)/payment$#s', $pathinfo, $matches)) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiBillingUpdatePayment;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingUpdatePayment', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingUpdatePayment')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::updatePaymentAction',));
                    }
                    not_apiBillingUpdatePayment:

                    // apiBillingPaymentPage
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)/paymentpage$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiBillingPaymentPage;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingPaymentPage', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingPaymentPage')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::getPaymentServicePageURL',));
                    }
                    not_apiBillingPaymentPage:

                    // apiBillingCreate
                    if ('/api/billing/create' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiBillingCreate;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingCreate', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::createBillingAction',  '_route' => 'apiBillingCreate',);
                    }
                    not_apiBillingCreate:

                    // apiBillingPortalRead
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)/portal$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiBillingPortalRead;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingPortalRead', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingPortalRead')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::readBillingPortalAction',));
                    }
                    not_apiBillingPortalRead:

                    // apiBillingUpdate
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiBillingUpdate;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingUpdate', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::updateBillingAction',));
                    }
                    not_apiBillingUpdate:

                    // apiBillingActivate
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)/activate$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiBillingActivate;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingActivate', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingActivate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::activateBillingAction',));
                    }
                    not_apiBillingActivate:

                    // apiBillingGet
                    if (preg_match('#^/api/billing/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiBillingGet;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiBillingGet', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiBillingGet')), array (  '_controller' => 'AppBundle\\Controller\\Api\\BillingController::getBillingAction',));
                    }
                    not_apiBillingGet:

                }

                elseif (0 === strpos($pathinfo, '/api/co')) {
                    if (0 === strpos($pathinfo, '/api/companies')) {
                        // apiCompanyAdd
                        if ('/api/companies' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCompanyAdd;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyAdd', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\CompanyController::newAction',  '_route' => 'apiCompanyAdd',);
                        }
                        not_apiCompanyAdd:

                        // apiCompanyList
                        if ('/api/companies' === $pathinfo) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyList', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\CompanyController::listAction',  '_route' => 'apiCompanyList',);
                        }
                        not_apiCompanyList:

                    }

                    elseif (0 === strpos($pathinfo, '/api/company')) {
                        // apiAccount
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/account$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiAccount;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiAccount', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiAccount')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CompanyController::accountAction',));
                        }
                        not_apiAccount:

                        // apiCompanyQbIntegration
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/qbIntegration$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCompanyQbIntegration;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyQbIntegration', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyQbIntegration')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CompanyController::QbIntegrationAction',));
                        }
                        not_apiCompanyQbIntegration:

                        // apiExportQbConnector
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/qbConnector$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiExportQbConnector;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiExportQbConnector', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiExportQbConnector')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CompanyController::exportAction',));
                        }
                        not_apiExportQbConnector:

                        // apiCompanyName
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/name$#s', $pathinfo, $matches)) {
                            if ('PUT' !== $canonicalMethod) {
                                $allow[] = 'PUT';
                                goto not_apiCompanyName;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyName', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyName')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CompanyController::companyNameAction',));
                        }
                        not_apiCompanyName:

                        // apiEmployeeNew
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/employees$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeeNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeNew', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeNew')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::newAction',));
                        }
                        not_apiEmployeeNew:

                        // apiEmployeeList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/employees$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiEmployeeList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::listAction',));
                        }
                        not_apiEmployeeList:

                        // apiCompanyApproversList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/approvers/?$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyApproversList;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'apiCompanyApproversList');
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyApproversList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyApproversList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::getCompanyApproversAction',));
                        }
                        not_apiCompanyApproversList:

                        // apiCompanyApproversFilterList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/approversfilter/?$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyApproversFilterList;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($rawPathinfo.'/', 'apiCompanyApproversFilterList');
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyApproversFilterList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyApproversFilterList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::getCompanyApproversFilterAction',));
                        }
                        not_apiCompanyApproversFilterList:

                        // apiExportCompanyList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/export/list$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiExportCompanyList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiExportCompanyList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiExportCompanyList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ExportController::companyForExportListAction',));
                        }
                        not_apiExportCompanyList:

                        // apiExportCompanyDefault
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/export$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiExportCompanyDefault;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiExportCompanyDefault', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiExportCompanyDefault')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ExportController::exportAction',));
                        }
                        not_apiExportCompanyDefault:

                        // apiAdhocExportReviewDashboard
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/export/adhoclist$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiAdhocExportReviewDashboard;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiAdhocExportReviewDashboard', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiAdhocExportReviewDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ExportController::adhocExportReviewAction',));
                        }
                        not_apiAdhocExportReviewDashboard:

                        // apiImportCCStatement
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/import/ccStatement$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiImportCCStatement;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiImportCCStatement', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiImportCCStatement')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ImportedTransactionController::importCCStatementAction',));
                        }
                        not_apiImportCCStatement:

                        // apiImportedTransactionDeleteDuplicates
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/importedTransactions/deleteduplicates$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiImportedTransactionDeleteDuplicates;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiImportedTransactionDeleteDuplicates', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiImportedTransactionDeleteDuplicates')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ImportedTransactionController::deleteDuplicatesAction',));
                        }
                        not_apiImportedTransactionDeleteDuplicates:

                        // apiPaymentTypeNew
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/paymentTypes$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiPaymentTypeNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypeNew', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPaymentTypeNew')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::newAction',));
                        }
                        not_apiPaymentTypeNew:

                        // apiEmployeePaymentTypeNew
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/employee/paymentTypes/add$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeePaymentTypeNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeePaymentTypeNew', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeePaymentTypeNew')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::newEmployeePaymentTypeAction',));
                        }
                        not_apiEmployeePaymentTypeNew:

                        // apiEmployeePaymentTypeRemove
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/employee/paymentTypes/remove$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeePaymentTypeRemove;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeePaymentTypeRemove', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeePaymentTypeRemove')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::removeEmployeePaymentTypeAction',));
                        }
                        not_apiEmployeePaymentTypeRemove:

                        // apiPaymentTypesCompanyList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/paymentTypesList$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiPaymentTypesCompanyList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypesCompanyList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPaymentTypesCompanyList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::companyPaymentTypeListAction',));
                        }
                        not_apiPaymentTypesCompanyList:

                        // apiTransactionTypesCompanyList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/transactionTypes$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiTransactionTypesCompanyList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiTransactionTypesCompanyList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiTransactionTypesCompanyList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::companyTransactionTypesAction',));
                        }
                        not_apiTransactionTypesCompanyList:

                        // apiPaymentTypesCompanyListWeb
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/paymentTypesListWeb$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiPaymentTypesCompanyListWeb;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypesCompanyListWeb', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPaymentTypesCompanyListWeb')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::companyPaymentTypesListWebAction',));
                        }
                        not_apiPaymentTypesCompanyListWeb:

                        // apiAllPaymentTypesCompanyList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/allPaymentTypesList$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiAllPaymentTypesCompanyList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiAllPaymentTypesCompanyList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiAllPaymentTypesCompanyList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::companyAllPaymentTypeListAction',));
                        }
                        not_apiAllPaymentTypesCompanyList:

                        // apiPaymentTypeCompanyList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/user/(?P<employeeid>[^/]++)/paymentTypes$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiPaymentTypeCompanyList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypeCompanyList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPaymentTypeCompanyList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::userListAction',));
                        }
                        not_apiPaymentTypeCompanyList:

                        // apiCompanyProjectList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/projects$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyProjectList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyProjectList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyProjectList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::companyListAction',));
                        }
                        not_apiCompanyProjectList:

                        // apiCustomerJobs
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/customerJobs$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCustomerJobs;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCustomerJobs', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCustomerJobs')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::getCustomerJobsAction',));
                        }
                        not_apiCustomerJobs:

                        // apiCustomerJob
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/customerJob$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCustomerJob;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCustomerJob', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCustomerJob')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::newCustomerJobAction',));
                        }
                        not_apiCustomerJob:

                        // apiPurchaseClassNew
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/purchaseClass$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiPurchaseClassNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPurchaseClassNew', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseClassNew')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseClassController::newAction',));
                        }
                        not_apiPurchaseClassNew:

                        // apiPurchaseClassList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/purchaseClassList$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiPurchaseClassList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPurchaseClassList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseClassList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseClassController::companyPurchaseClassListAction',));
                        }
                        not_apiPurchaseClassList:

                        // apiCompanyPurchaseList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/purchases$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyPurchaseList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyPurchaseList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyPurchaseList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::companyListAction',));
                        }
                        not_apiCompanyPurchaseList:

                        // apiCompanyPurchaseListUnapproved
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/unapprovedpurchases$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyPurchaseListUnapproved;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyPurchaseListUnapproved', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyPurchaseListUnapproved')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::companyListUnapprovedAction',));
                        }
                        not_apiCompanyPurchaseListUnapproved:

                        // apiCompanyPurchaseListApprover
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/approver/purchases$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyPurchaseListApprover;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyPurchaseListApprover', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyPurchaseListApprover')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::companyListApproverAction',));
                        }
                        not_apiCompanyPurchaseListApprover:

                        // apiCompanyResetDemo
                        if ('/api/company/resetdemo' === $pathinfo) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyResetDemo;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyResetDemo', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::companyResetDemoAction',  '_route' => 'apiCompanyResetDemo',);
                        }
                        not_apiCompanyResetDemo:

                        // apiCompanyPurchaseListApproverUnapproved
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/approver/unapprovedpurchases$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyPurchaseListApproverUnapproved;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyPurchaseListApproverUnapproved', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyPurchaseListApproverUnapproved')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::companyListApproverUnapprovedAction',));
                        }
                        not_apiCompanyPurchaseListApproverUnapproved:

                        // apiExportQbExceptions
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/export/qbExceptions$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiExportQbExceptions;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiExportQbExceptions', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiExportQbExceptions')), array (  '_controller' => 'AppBundle\\Controller\\Api\\QbExceptionController::exportAction',));
                        }
                        not_apiExportQbExceptions:

                        // apiQbCheckQueue
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/qb/checkqueue$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiQbCheckQueue;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiQbCheckQueue', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiQbCheckQueue')), array (  '_controller' => 'AppBundle\\Controller\\Api\\QbExceptionController::checkQueueAction',));
                        }
                        not_apiQbCheckQueue:

                        // apiEmailQbExceptions
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/email/qbExceptions$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmailQbExceptions;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmailQbExceptions', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmailQbExceptions')), array (  '_controller' => 'AppBundle\\Controller\\Api\\QbExceptionController::emailAction',));
                        }
                        not_apiEmailQbExceptions:

                        // apiReconcile
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/reconcile$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiReconcile;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiReconcile', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiReconcile')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ReconcileController::reconcileAction',));
                        }
                        not_apiReconcile:

                        // apiCompanyReminderSendScheduled
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/reminder/scheduled$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCompanyReminderSendScheduled;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyReminderSendScheduled', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyReminderSendScheduled')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ReminderController::getCompanyScheduledReminders',));
                        }
                        not_apiCompanyReminderSendScheduled:

                        // apiVendorNew
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/vendors$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiVendorNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiVendorNew', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiVendorNew')), array (  '_controller' => 'AppBundle\\Controller\\Api\\VendorController::newAction',));
                        }
                        not_apiVendorNew:

                        // apiCompanyVendorList
                        if (preg_match('#^/api/company/(?P<id>[^/]++)/vendors$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCompanyVendorList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyVendorList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCompanyVendorList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\VendorController::vendorListAction',));
                        }
                        not_apiCompanyVendorList:

                    }

                    elseif (0 === strpos($pathinfo, '/api/costs')) {
                        // apiCostNew
                        if ('/api/costs' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCostNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCostNew', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\CostController::newAction',  '_route' => 'apiCostNew',);
                        }
                        not_apiCostNew:

                        // apiCostUpdate
                        if (preg_match('#^/api/costs/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('PUT' !== $canonicalMethod) {
                                $allow[] = 'PUT';
                                goto not_apiCostUpdate;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCostUpdate', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCostUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CostController::updateAction',));
                        }
                        not_apiCostUpdate:

                        // apiCostBudget
                        if (preg_match('#^/api/costs/(?P<id>[^/]++)/budget$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiCostBudget;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCostBudget', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCostBudget')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CostController::budgetAction',));
                        }
                        not_apiCostBudget:

                        // apiCostDelete
                        if (preg_match('#^/api/costs/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiCostDelete;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCostDelete', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiCostDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CostController::deleteAction',));
                        }
                        not_apiCostDelete:

                        // apiEnableCost
                        if (preg_match('#^/api/costs/(?P<id>[^/]++)/toggle$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEnableCost;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEnableCost', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEnableCost')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CostController::enableAction',));
                        }
                        not_apiEnableCost:

                    }

                }

                elseif (0 === strpos($pathinfo, '/api/p')) {
                    if (0 === strpos($pathinfo, '/api/project')) {
                        // apiProjectCostList
                        if (preg_match('#^/api/project/(?P<id>[^/]++)/costs$#s', $pathinfo, $matches)) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiProjectCostList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiProjectCostList', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiProjectCostList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\CostController::projectListAction',));
                        }
                        not_apiProjectCostList:

                        if (0 === strpos($pathinfo, '/api/projects')) {
                            // apiProjectNew
                            if ('/api/projects' === $pathinfo) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_apiProjectNew;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiProjectNew', key($requiredSchemes));
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::newAction',  '_route' => 'apiProjectNew',);
                            }
                            not_apiProjectNew:

                            // apiProjectShow
                            if (preg_match('#^/api/projects/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ('GET' !== $canonicalMethod) {
                                    $allow[] = 'GET';
                                    goto not_apiProjectShow;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiProjectShow', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiProjectShow')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::showAction',));
                            }
                            not_apiProjectShow:

                            // apiAllProjectList
                            if ('/api/projects' === $pathinfo) {
                                if ('GET' !== $canonicalMethod) {
                                    $allow[] = 'GET';
                                    goto not_apiAllProjectList;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiAllProjectList', key($requiredSchemes));
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::listAction',  '_route' => 'apiAllProjectList',);
                            }
                            not_apiAllProjectList:

                            // apiProjectUpdate
                            if (preg_match('#^/api/projects/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($requestMethod, array('PUT', 'PATCH'))) {
                                    $allow = array_merge($allow, array('PUT', 'PATCH'));
                                    goto not_apiProjectUpdate;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiProjectUpdate', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiProjectUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::updateAction',));
                            }
                            not_apiProjectUpdate:

                        }

                        // apiProjectDelete
                        if (preg_match('#^/api/project/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiProjectDelete;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiProjectDelete', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiProjectDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::deleteAction',));
                        }
                        not_apiProjectDelete:

                        // apiImportBudget
                        if ('/api/projects/import/budget' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiImportBudget;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiImportBudget', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::importBudgetAction',  '_route' => 'apiImportBudget',);
                        }
                        not_apiImportBudget:

                    }

                    elseif (0 === strpos($pathinfo, '/api/paymentTypes')) {
                        // apiPaymentTypeDelete
                        if (preg_match('#^/api/paymentTypes/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiPaymentTypeDelete;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypeDelete', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPaymentTypeDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::deleteAction',));
                        }
                        not_apiPaymentTypeDelete:

                        // apiPaymentTypeAssociateTransactionType
                        if (preg_match('#^/api/paymentTypes/(?P<id>[^/]++)/associatetransactiontype$#s', $pathinfo, $matches)) {
                            if ('PUT' !== $canonicalMethod) {
                                $allow[] = 'PUT';
                                goto not_apiPaymentTypeAssociateTransactionType;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypeAssociateTransactionType', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPaymentTypeAssociateTransactionType')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::associateTransactionTypeAction',));
                        }
                        not_apiPaymentTypeAssociateTransactionType:

                        // apiPaymentTypeEmployeeList
                        if ('/api/paymentTypes' === $pathinfo) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiPaymentTypeEmployeeList;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPaymentTypeEmployeeList', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\PaymentTypeController::employeeListAction',  '_route' => 'apiPaymentTypeEmployeeList',);
                        }
                        not_apiPaymentTypeEmployeeList:

                    }

                    // apiPasswordSet
                    if ('/api/password/set' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiPasswordSet;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiPasswordSet', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::setPasswordAction',  '_route' => 'apiPasswordSet',);
                    }
                    not_apiPasswordSet:

                    if (0 === strpos($pathinfo, '/api/purchase')) {
                        // apiPurchaseClassDelete
                        if (0 === strpos($pathinfo, '/api/purchaseclass') && preg_match('#^/api/purchaseclass/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiPurchaseClassDelete;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPurchaseClassDelete', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseClassDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseClassController::deleteAction',));
                        }
                        not_apiPurchaseClassDelete:

                        if (0 === strpos($pathinfo, '/api/purchases')) {
                            // apiPurchaseNew
                            if ('/api/purchases' === $pathinfo) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_apiPurchaseNew;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseNew', key($requiredSchemes));
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::newAction',  '_route' => 'apiPurchaseNew',);
                            }
                            not_apiPurchaseNew:

                            // apiPurchaseBudgetCheck
                            if ('/api/purchases/budgetcheck' === $pathinfo) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_apiPurchaseBudgetCheck;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseBudgetCheck', key($requiredSchemes));
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::checkBudgetAction',  '_route' => 'apiPurchaseBudgetCheck',);
                            }
                            not_apiPurchaseBudgetCheck:

                            // apiPurchaseUpdate
                            if (preg_match('#^/api/purchases/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($requestMethod, array('PUT', 'PATCH'))) {
                                    $allow = array_merge($allow, array('PUT', 'PATCH'));
                                    goto not_apiPurchaseUpdate;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseUpdate', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::updateAction',));
                            }
                            not_apiPurchaseUpdate:

                            // apiPurchaseApprove
                            if (preg_match('#^/api/purchases/(?P<id>[^/]++)/approve$#s', $pathinfo, $matches)) {
                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseApprove', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseApprove')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::approveAction',));
                            }

                            // apiPurchaseDecline
                            if (preg_match('#^/api/purchases/(?P<id>[^/]++)/decline$#s', $pathinfo, $matches)) {
                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseDecline', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseDecline')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::declineAction',));
                            }

                            // apiSetPurchaseVendor
                            if (preg_match('#^/api/purchases/(?P<id>[^/]++)/vendor$#s', $pathinfo, $matches)) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_apiSetPurchaseVendor;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiSetPurchaseVendor', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiSetPurchaseVendor')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::setVendorAction',));
                            }
                            not_apiSetPurchaseVendor:

                        }

                        elseif (0 === strpos($pathinfo, '/api/purchaseItems')) {
                            // apiPurchaseItemNew
                            if ('/api/purchaseItems' === $pathinfo) {
                                if ('POST' !== $canonicalMethod) {
                                    $allow[] = 'POST';
                                    goto not_apiPurchaseItemNew;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseItemNew', key($requiredSchemes));
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::newItemAction',  '_route' => 'apiPurchaseItemNew',);
                            }
                            not_apiPurchaseItemNew:

                            // apiPurchaseItemDelete
                            if (preg_match('#^/api/purchaseItems/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ('DELETE' !== $canonicalMethod) {
                                    $allow[] = 'DELETE';
                                    goto not_apiPurchaseItemDelete;
                                }

                                $requiredSchemes = array (  'http' => 0,);
                                if (!isset($requiredSchemes[$scheme])) {
                                    return $this->redirect($rawPathinfo, 'apiPurchaseItemDelete', key($requiredSchemes));
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseItemDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::deleteItemAction',));
                            }
                            not_apiPurchaseItemDelete:

                        }

                        // apiAssociatePurchaseClass
                        if (preg_match('#^/api/purchase/(?P<id>[^/]++)/associatepurchaseclass$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiAssociatePurchaseClass;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiAssociatePurchaseClass', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiAssociatePurchaseClass')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::associateClassAction',));
                        }
                        not_apiAssociatePurchaseClass:

                        // apiPurchaseDelete
                        if (preg_match('#^/api/purchase/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiPurchaseDelete;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiPurchaseDelete', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiPurchaseDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::deleteAction',));
                        }
                        not_apiPurchaseDelete:

                        // apiQbExceptionNew
                        if (0 === strpos($pathinfo, '/api/purchaseItems') && preg_match('#^/api/purchaseItems/(?P<id>[^/]++)/qbException$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiQbExceptionNew;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiQbExceptionNew', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiQbExceptionNew')), array (  '_controller' => 'AppBundle\\Controller\\Api\\QbExceptionController::newAction',));
                        }
                        not_apiQbExceptionNew:

                    }

                }

                elseif (0 === strpos($pathinfo, '/api/e')) {
                    if (0 === strpos($pathinfo, '/api/employees')) {
                        // apiEmployeeSetDone
                        if (preg_match('#^/api/employees/(?P<id>[^/]++)/setDone$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeeSetDone;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeSetDone', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeSetDone')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::setDoneAction',));
                        }
                        not_apiEmployeeSetDone:

                        // apiEmployeeSetImportedToQb
                        if (preg_match('#^/api/employees/(?P<id>[^/]++)/importedqb$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeeSetImportedToQb;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeSetImportedToQb', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeSetImportedToQb')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::setImportedToQbAction',));
                        }
                        not_apiEmployeeSetImportedToQb:

                        // apiEmployeeNotifyQb
                        if ('/api/employees/notifyqb' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeeNotifyQb;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeNotifyQb', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::notifyQbAction',  '_route' => 'apiEmployeeNotifyQb',);
                        }
                        not_apiEmployeeNotifyQb:

                        // apiEmployeeUpdate
                        if (preg_match('#^/api/employees/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($requestMethod, array('PUT', 'PATCH'))) {
                                $allow = array_merge($allow, array('PUT', 'PATCH'));
                                goto not_apiEmployeeUpdate;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeUpdate', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::updateAction',));
                        }
                        not_apiEmployeeUpdate:

                        // apiEmployeeDelete
                        if (preg_match('#^/api/employees/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ('DELETE' !== $canonicalMethod) {
                                $allow[] = 'DELETE';
                                goto not_apiEmployeeDelete;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeDelete', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::deleteAction',));
                        }
                        not_apiEmployeeDelete:

                        // apiEmployeeAddRole
                        if (preg_match('#^/api/employees/(?P<employeeId>[^/]++)/toggleRole$#s', $pathinfo, $matches)) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiEmployeeAddRole;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiEmployeeAddRole', key($requiredSchemes));
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiEmployeeAddRole')), array (  '_controller' => 'AppBundle\\Controller\\Api\\EmployeeController::toggleRoleAction',));
                        }
                        not_apiEmployeeAddRole:

                    }

                    // apiExportCustom
                    if ('/api/export/custom' === $pathinfo) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiExportCustom', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\ExportController::customAction',  '_route' => 'apiExportCustom',);
                    }

                    // apiExportDashboard
                    if ('/api/export/dashboard' === $pathinfo) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiExportDashboard;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiExportDashboard', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\ExportController::dashboardAction',  '_route' => 'apiExportDashboard',);
                    }
                    not_apiExportDashboard:

                }

                // apiImportedTransactionDelete
                if (0 === strpos($pathinfo, '/api/importedTransactions') && preg_match('#^/api/importedTransactions/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ('DELETE' !== $canonicalMethod) {
                        $allow[] = 'DELETE';
                        goto not_apiImportedTransactionDelete;
                    }

                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'apiImportedTransactionDelete', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiImportedTransactionDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\ImportedTransactionController::deleteAction',));
                }
                not_apiImportedTransactionDelete:

                // apiDownloadBudgetTemplate
                if ('/api/download/budgetTemplate' === $pathinfo) {
                    if ('GET' !== $canonicalMethod) {
                        $allow[] = 'GET';
                        goto not_apiDownloadBudgetTemplate;
                    }

                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'apiDownloadBudgetTemplate', key($requiredSchemes));
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\ProjectController::downloadBudgetTemplateAction',  '_route' => 'apiDownloadBudgetTemplate',);
                }
                not_apiDownloadBudgetTemplate:

                // apiDownloadCCStatementTemplate
                if ('/api/download/ccStatementTemplate' === $pathinfo) {
                    if ('GET' !== $canonicalMethod) {
                        $allow[] = 'GET';
                        goto not_apiDownloadCCStatementTemplate;
                    }

                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'apiDownloadCCStatementTemplate', key($requiredSchemes));
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Api\\PurchaseController::downloadCCStatementTemplateAction',  '_route' => 'apiDownloadCCStatementTemplate',);
                }
                not_apiDownloadCCStatementTemplate:

                if (0 === strpos($pathinfo, '/api/re')) {
                    // apiReconcileDeleteItems
                    if ('/api/reconcile/deleteItems' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiReconcileDeleteItems;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiReconcileDeleteItems', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\ReconcileController::deleteItemsAction',  '_route' => 'apiReconcileDeleteItems',);
                    }
                    not_apiReconcileDeleteItems:

                    // apiManualReconcile
                    if ('/api/reconcile/manual' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiManualReconcile;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiManualReconcile', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\ReconcileController::matchAction',  '_route' => 'apiManualReconcile',);
                    }
                    not_apiManualReconcile:

                    // apiReminderSendToAll
                    if ('/api/reminder/all' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiReminderSendToAll;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiReminderSendToAll', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\ReminderController::sendReminderToAllAction',  '_route' => 'apiReminderSendToAll',);
                    }
                    not_apiReminderSendToAll:

                    if (0 === strpos($pathinfo, '/api/reminder/scheduled')) {
                        // apiReminderSendScheduled
                        if ('/api/reminder/scheduled' === $pathinfo) {
                            if ('GET' !== $canonicalMethod) {
                                $allow[] = 'GET';
                                goto not_apiReminderSendScheduled;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiReminderSendScheduled', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\ReminderController::sendScheduledReminders',  '_route' => 'apiReminderSendScheduled',);
                        }
                        not_apiReminderSendScheduled:

                        // apiCompanyReminderScheduleSet
                        if ('/api/reminder/scheduled/set' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCompanyReminderScheduleSet;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCompanyReminderScheduleSet', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\ReminderController::setCompanyScheduledDays',  '_route' => 'apiCompanyReminderScheduleSet',);
                        }
                        not_apiCompanyReminderScheduleSet:

                    }

                }

                elseif (0 === strpos($pathinfo, '/api/users')) {
                    // apiUserNew
                    if ('/api/users' === $pathinfo) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiUserNew;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiUserNew', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::newAction',  '_route' => 'apiUserNew',);
                    }
                    not_apiUserNew:

                    // app_api_user_resetpassword
                    if (preg_match('#^/api/users/(?P<id>[^/]++)/resetpassword$#s', $pathinfo, $matches)) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_app_api_user_resetpassword;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'app_api_user_resetpassword', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_api_user_resetpassword')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::resetPasswordAction',));
                    }
                    not_app_api_user_resetpassword:

                    // apiUserShow
                    if (preg_match('#^/api/users/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiUserShow;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiUserShow', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiUserShow')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::showAction',));
                    }
                    not_apiUserShow:

                    // apiUserCompanyList
                    if (preg_match('#^/api/users/(?P<id>[^/]++)/companies$#s', $pathinfo, $matches)) {
                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiUserCompanyList', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiUserCompanyList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::listCompaniesAction',));
                    }

                    // apiUserList
                    if ('/api/users' === $pathinfo) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiUserList;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiUserList', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::listAction',  '_route' => 'apiUserList',);
                    }
                    not_apiUserList:

                    // apiUserUpdate
                    if (preg_match('#^/api/users/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($requestMethod, array('PUT', 'PATCH'))) {
                            $allow = array_merge($allow, array('PUT', 'PATCH'));
                            goto not_apiUserUpdate;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiUserUpdate', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiUserUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::updateAction',));
                    }
                    not_apiUserUpdate:

                    // apiUserDelete
                    if (preg_match('#^/api/users/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ('DELETE' !== $canonicalMethod) {
                            $allow[] = 'DELETE';
                            goto not_apiUserDelete;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiUserDelete', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiUserDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::deleteAction',));
                    }
                    not_apiUserDelete:

                    // apiSetDone
                    if (preg_match('#^/api/users/(?P<id>[^/]++)/setDone$#s', $pathinfo, $matches)) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiSetDone;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiSetDone', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiSetDone')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::setDoneAction',));
                    }
                    not_apiSetDone:

                    if (0 === strpos($pathinfo, '/api/users/current/setDone')) {
                        // apiCurrentSetDone
                        if ('/api/users/current/setDone' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCurrentSetDone;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCurrentSetDone', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::setCurrentUserDoneAction',  '_route' => 'apiCurrentSetDone',);
                        }
                        not_apiCurrentSetDone:

                        // apiCurrentSetDoneDuplicate
                        if ('/api/users/current/setDoneDuplicate' === $pathinfo) {
                            if ('POST' !== $canonicalMethod) {
                                $allow[] = 'POST';
                                goto not_apiCurrentSetDoneDuplicate;
                            }

                            $requiredSchemes = array (  'http' => 0,);
                            if (!isset($requiredSchemes[$scheme])) {
                                return $this->redirect($rawPathinfo, 'apiCurrentSetDoneDuplicate', key($requiredSchemes));
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::setCurrentUserDoneDuplicateAction',  '_route' => 'apiCurrentSetDoneDuplicate',);
                        }
                        not_apiCurrentSetDoneDuplicate:

                    }

                    // apiGetIsDone
                    if (preg_match('#^/api/users/(?P<id>[^/]++)/isDone$#s', $pathinfo, $matches)) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiGetIsDone;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiGetIsDone', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiGetIsDone')), array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::isDoneAction',));
                    }
                    not_apiGetIsDone:

                    // apiIsDoneCCI
                    if ('/api/users/isDone/cci' === $pathinfo) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiIsDoneCCI;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiIsDoneCCI', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::isDoneCostCodeInstructions',  '_route' => 'apiIsDoneCCI',);
                    }
                    not_apiIsDoneCCI:

                    // apiIsDoneWizard
                    if ('/api/users/isDone/wizard' === $pathinfo) {
                        if ('GET' !== $canonicalMethod) {
                            $allow[] = 'GET';
                            goto not_apiIsDoneWizard;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiIsDoneWizard', key($requiredSchemes));
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Api\\UserController::isDoneWizard',  '_route' => 'apiIsDoneWizard',);
                    }
                    not_apiIsDoneWizard:

                }

                elseif (0 === strpos($pathinfo, '/api/vendors')) {
                    // apiVendorDelete
                    if (preg_match('#^/api/vendors/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ('DELETE' !== $canonicalMethod) {
                            $allow[] = 'DELETE';
                            goto not_apiVendorDelete;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiVendorDelete', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiVendorDelete')), array (  '_controller' => 'AppBundle\\Controller\\Api\\VendorController::deleteAction',));
                    }
                    not_apiVendorDelete:

                    // apiVendorUpdate
                    if (preg_match('#^/api/vendors/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($requestMethod, array('PUT', 'PATCH'))) {
                            $allow = array_merge($allow, array('PUT', 'PATCH'));
                            goto not_apiVendorUpdate;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiVendorUpdate', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiVendorUpdate')), array (  '_controller' => 'AppBundle\\Controller\\Api\\VendorController::updateAction',));
                    }
                    not_apiVendorUpdate:

                    // apiVendorMerge
                    if (preg_match('#^/api/vendors/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ('POST' !== $canonicalMethod) {
                            $allow[] = 'POST';
                            goto not_apiVendorMerge;
                        }

                        $requiredSchemes = array (  'http' => 0,);
                        if (!isset($requiredSchemes[$scheme])) {
                            return $this->redirect($rawPathinfo, 'apiVendorMerge', key($requiredSchemes));
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'apiVendorMerge')), array (  '_controller' => 'AppBundle\\Controller\\Api\\VendorController::mergeAction',));
                    }
                    not_apiVendorMerge:

                }

            }

        }

        // employeeRolesPage
        if ('/employeeRoles' === $pathinfo) {
            $requiredSchemes = array (  'http' => 0,);
            if (!isset($requiredSchemes[$scheme])) {
                return $this->redirect($rawPathinfo, 'employeeRolesPage', key($requiredSchemes));
            }

            return array (  '_controller' => 'AppBundle\\Controller\\Web\\BillingController::indexAction',  '_route' => 'employeeRolesPage',);
        }

        if (0 === strpos($pathinfo, '/dashboard')) {
            // approverPage
            if ('/dashboard/approver' === $pathinfo) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'approverPage', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::ApproverAction',  '_route' => 'approverPage',);
            }

            // accountantPage
            if ('/dashboard/accountant' === $pathinfo) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'accountantPage', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::AccountantAction',  '_route' => 'accountantPage',);
            }

            // dashboardPage
            if ('/dashboard' === $pathinfo) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'dashboardPage', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::indexAction',  '_route' => 'dashboardPage',);
            }

            // showSetupWizardDashboard
            if (0 === strpos($pathinfo, '/dashboard/setupwizard/company') && preg_match('#^/dashboard/setupwizard/company/(?P<id>[^/]++)/(?P<employeeId>[^/]++)$#s', $pathinfo, $matches)) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'showSetupWizardDashboard', key($requiredSchemes));
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'showSetupWizardDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showSetupWizardAction',));
            }

            if (0 === strpos($pathinfo, '/dashboard/admin/users')) {
                // dashboardAdminUsersCompanyPage
                if (preg_match('#^/dashboard/admin/users/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'dashboardAdminUsersCompanyPage', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'dashboardAdminUsersCompanyPage')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::dashboardAdminUsersAction',));
                }

                // dashboardAdminUsersPage
                if ('/dashboard/admin/users' === $pathinfo) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'dashboardAdminUsersPage', key($requiredSchemes));
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::adminUsersAction',  '_route' => 'dashboardAdminUsersPage',);
                }

            }

            elseif (0 === strpos($pathinfo, '/dashboard/company')) {
                // showCompanyDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showCompanyAction',));
                }

                // showCompanyAccountantDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/accountant$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyAccountantDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyAccountantDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showCompanyAccountantAction',));
                }

                // showCompanyAccountDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/account$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyAccountDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyAccountDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showCompanyAccountAction',));
                }

                // showCompanyPaymentTypesDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/paymenttypes$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyPaymentTypesDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyPaymentTypesDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::PaymentTypesAction',));
                }

                // classesCompanyDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/classes$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'classesCompanyDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'classesCompanyDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::classesAction',));
                }

                // vendorsCompanyDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/vendors$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'vendorsCompanyDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'vendorsCompanyDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::vendorsAction',));
                }

                // showCompanyApproverDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/approver$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyApproverDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyApproverDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showCompanyApproverAction',));
                }

                // showCompanyUserDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/users$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyUserDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyUserDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showCompanyUserAction',));
                }

                // showCompanyAdminDashboard
                if (preg_match('#^/dashboard/company/(?P<id>[^/]++)/admin$#s', $pathinfo, $matches)) {
                    $requiredSchemes = array (  'http' => 0,);
                    if (!isset($requiredSchemes[$scheme])) {
                        return $this->redirect($rawPathinfo, 'showCompanyAdminDashboard', key($requiredSchemes));
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showCompanyAdminDashboard')), array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::showCompanyAdminAction',));
                }

            }

            // dashboardTestPage
            if ('/dashboard/test' === $pathinfo) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'dashboardTestPage', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Web\\DashboardController::testDashboardAction',  '_route' => 'dashboardTestPage',);
            }

        }

        // homepage
        if ('' === $trimmedPathinfo) {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($rawPathinfo.'/', 'homepage');
            }

            $requiredSchemes = array (  'http' => 0,);
            if (!isset($requiredSchemes[$scheme])) {
                return $this->redirect($rawPathinfo, 'homepage', key($requiredSchemes));
            }

            return array (  '_controller' => 'AppBundle\\Controller\\Web\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/mobile')) {
            // defaultInvalidDevice
            if ('/mobile/invalid_device' === $pathinfo) {
                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'defaultInvalidDevice', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Web\\DefaultController::mobileRedirect',  '_route' => 'defaultInvalidDevice',);
            }

            // mobileVerify
            if ('/mobile/verify' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_mobileVerify;
                }

                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'mobileVerify', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\MobileController::verifyAction',  '_route' => 'mobileVerify',);
            }
            not_mobileVerify:

            // apiEmployeePurchaseList
            if ('/mobile/purchases' === $pathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_apiEmployeePurchaseList;
                }

                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'apiEmployeePurchaseList', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\MobileController::purchaseListAction',  '_route' => 'apiEmployeePurchaseList',);
            }
            not_apiEmployeePurchaseList:

            // mobileAllProjectList
            if ('/mobile/projects' === $pathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_mobileAllProjectList;
                }

                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'mobileAllProjectList', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\MobileController::projectListAction',  '_route' => 'mobileAllProjectList',);
            }
            not_mobileAllProjectList:

            // mobileCostList
            if (0 === strpos($pathinfo, '/mobile/cost') && preg_match('#^/mobile/cost/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_mobileCostList;
                }

                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'mobileCostList', key($requiredSchemes));
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'mobileCostList')), array (  '_controller' => 'AppBundle\\Controller\\Api\\MobileController::costListAction',));
            }
            not_mobileCostList:

            // mobileAddUser
            if ('/mobile/adduser' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_mobileAddUser;
                }

                $requiredSchemes = array (  'http' => 0,);
                if (!isset($requiredSchemes[$scheme])) {
                    return $this->redirect($rawPathinfo, 'mobileAddUser', key($requiredSchemes));
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Api\\MobileController::signUpAction',  '_route' => 'mobileAddUser',);
            }
            not_mobileAddUser:

        }

        // projectPage
        if (0 === strpos($pathinfo, '/project') && preg_match('#^/project/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            $requiredSchemes = array (  'http' => 0,);
            if (!isset($requiredSchemes[$scheme])) {
                return $this->redirect($rawPathinfo, 'projectPage', key($requiredSchemes));
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'projectPage')), array (  '_controller' => 'AppBundle\\Controller\\Web\\ProjectController::DetailsAction',));
        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if ('/profile' === $trimmedPathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($rawPathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ('/profile/edit' === $pathinfo) {
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

            // fos_user_change_password
            if ('/profile/change-password' === $pathinfo) {
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_change_password;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
            }
            not_fos_user_change_password:

        }

        elseif (0 === strpos($pathinfo, '/login')) {
            // fos_user_security_login
            if ('/login' === $pathinfo) {
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_security_login;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
            }
            not_fos_user_security_login:

            // fos_user_security_check
            if ('/login_check' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_fos_user_security_check;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
            }
            not_fos_user_security_check:

        }

        // fos_user_security_logout
        if ('/logout' === $pathinfo) {
            if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                $allow = array_merge($allow, array('GET', 'POST'));
                goto not_fos_user_security_logout;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
        }
        not_fos_user_security_logout:

        if (0 === strpos($pathinfo, '/register')) {
            // fos_user_registration_register
            if ('/register' === $trimmedPathinfo) {
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_registration_register;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($rawPathinfo.'/', 'fos_user_registration_register');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
            }
            not_fos_user_registration_register:

            // fos_user_registration_check_email
            if ('/register/check-email' === $pathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_fos_user_registration_check_email;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
            }
            not_fos_user_registration_check_email:

            if (0 === strpos($pathinfo, '/register/confirm')) {
                // fos_user_registration_confirm
                if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if ('GET' !== $canonicalMethod) {
                        $allow[] = 'GET';
                        goto not_fos_user_registration_confirm;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                }
                not_fos_user_registration_confirm:

                // fos_user_registration_confirmed
                if ('/register/confirmed' === $pathinfo) {
                    if ('GET' !== $canonicalMethod) {
                        $allow[] = 'GET';
                        goto not_fos_user_registration_confirmed;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                }
                not_fos_user_registration_confirmed:

            }

        }

        elseif (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ('/resetting/request' === $pathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_fos_user_resetting_request;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($canonicalMethod, array('GET', 'POST'))) {
                    $allow = array_merge($allow, array('GET', 'POST'));
                    goto not_fos_user_resetting_reset;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'AppBundle\\Controller\\ResettingController::resetAction',));
            }
            not_fos_user_resetting_reset:

            // fos_user_resetting_send_email
            if ('/resetting/send-email' === $pathinfo) {
                if ('POST' !== $canonicalMethod) {
                    $allow[] = 'POST';
                    goto not_fos_user_resetting_send_email;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ('/resetting/check-email' === $pathinfo) {
                if ('GET' !== $canonicalMethod) {
                    $allow[] = 'GET';
                    goto not_fos_user_resetting_check_email;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
            }
            not_fos_user_resetting_check_email:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
