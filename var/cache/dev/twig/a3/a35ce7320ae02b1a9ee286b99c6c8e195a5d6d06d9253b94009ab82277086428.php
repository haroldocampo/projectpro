<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* base.html.twig */
class __TwigTemplate_ee1f43e09d0bcb7f2d3716162cea5545c60942aeb2aa3a9c2cf8d63eed055181 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'pageheader' => [$this, 'block_pageheader'],
            'body' => [$this, 'block_body'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\"/>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"description\" content=\"Project Pro\">
        <meta name=\"author\" content=\"Harold Ocampo\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <title>
            ";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        // line 11
        echo "        </title>
        ";
        // line 12
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 13
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/pprologo.png"), "html", null, true);
        echo "\"/>
        <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/toastr/toastr.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/morris/morris.css"), "html", null, true);
        echo "\">
        <link href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/switchery/switchery.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\"/>
        <link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/css/bootstrap-datepicker.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\"/>
        <link href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/css/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/public/stylesheets/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/ekko-lightbox/dist/ekko-lightbox.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular-ui-select/dist/select.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("font-awesome/css/font-awesome.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
        <link href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/css/overrides.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/bootstrap-select/dist/css/bootstrap-select.min.css"), "html", null, true);
        echo "\"/>
        <link rel=\"stylesheet\" href=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular-loading/loading-bar.css"), "html", null, true);
        echo "\"/>
        <link rel=\"stylesheet\" href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/drift/dist/Drift.min.js"), "html", null, true);
        echo "\"/>
        <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/modernizr.min.js"), "html", null, true);
        echo "\"></script>
        <!--[if !IE]><!-->
        <link href=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/css/ie-overrides.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
        <!--<![endif]-->
        <style>
            .ng-cloak,
            .x-ng-cloak,
            [data-ng-cloak],
            [ng-cloak],
            [ng\\:cloak],
            [x-ng-cloak] {
                display: none !important;
            }
            .click{
                cursor: pointer;
            }
        </style>

        <!-- link to the SqPaymentForm library -->
        <script type=\"text/javascript\" src=\"https://js.squareup.com/v2/paymentform\"></script>

        <!-- link to the local SqPaymentForm initialization -->
        <script type=\"text/javascript\" src=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("sqpayment/sqpaymentform.js"), "html", null, true);
        echo "\"></script>

        <!-- link to the custom styles for SqPaymentForm -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 53
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("sqpayment/sqpaymentform.css"), "html", null, true);
        echo "\">

    </head>
    <body data-ng-app=\"ProjexApp\" class=\"ng-cloak\">

        <!-- Navigation Bar-->
        <header id=\"topnav\">
            <div class=\"topbar-main\">
                <div data-ng-controller=\"CompanyController\" class=\"container relative\">

                    <!-- LOGO -->
                    <div class=\"topbar-left\">
                        <a href=\"#\" class=\"logo\">
                            <img src=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-web-banner.png"), "html", null, true);
        echo "\"/>
                        </a>
                    </div>

                    <div style=\"display: none;\">
                        <div class=\"upgrade-section\">
                            <span data-ng-if=\"!processingPayment\">{[trialDaysLeft]} Days Left in Free Trial</span>
                            <a href=\"/dashboard/company/";
        // line 73
        echo twig_escape_filter($this->env, (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 73, $this->source); })()), "html", null, true);
        echo "/account\">
                                <button data-ng-if=\"!processingPayment\" data-toggle=\"modal\" data-target=\"#creditCartModal\">UPGRADE NOW</button>
                            </a>
                            <span data-ng-if=\"processingPayment\">Processing Payment</span>

                        </div>
                    </div>

                    <div data-ng-controller=\"CompaniesController\" class=\"btn-group company-section\" style=\"\">
                        <button type=\"button\" style=\"\" class=\"btn bg-white border dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">{[ selectedCompany ]}<span class=\"caret\" style=\"margin-left: 7px;\"></span>
                        </button>
                        <div class=\"dropdown-menu\" style=\"overflow: scroll; height: auto; max-height: 350px;\">
                            ";
        // line 85
        if (($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN") || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 85, $this->source); })()), "hasRole", [0 => "ROLE_ADMIN"], "method", false, false, false, 85))) {
            // line 86
            echo "                                <a class=\"dropdown-item\" style=\"color: #FFF;background: #315da6;\" data-toggle=\"modal\" data-target=\"#newCompanyModal\">Create New Company</a>
                            ";
        }
        // line 88
        echo "                            <a class=\"dropdown-item\" data-ng-repeat=\"c in companies\" data-ng-href=\"/dashboard/company/{[ c.id ]}\">{[ c.name ]}</a>
                            ";
        // line 90
        echo "                            ";
        // line 91
        echo "                            ";
        // line 92
        echo "                            ";
        // line 93
        echo "                            ";
        // line 94
        echo "                            ";
        // line 95
        echo "                            ";
        // line 96
        echo "                            ";
        // line 97
        echo "                        </div>
                    </div>
                    <!-- End Logo container-->

                    <div class=\"menu-extras\">

                        <ul class=\"nav navbar-nav pull-right\">

                            <li class=\"nav-item\">
                                <!-- Mobile menu toggle-->
                                <a class=\"navbar-toggle\">
                                    <div class=\"lines\">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                            <li class=\"nav-item dropdown notification-list\" data-ng-controller=\"MenuController\">
                                <a class=\"nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"false\" aria-expanded=\"false\">
                                    <span class=\"hello-name\">Hello
                                        ";
        // line 120
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 120, $this->source); })()), "user", [], "any", false, false, false, 120), "firstName", [], "any", false, false, false, 120), "html", null, true);
        echo "
                                        ";
        // line 121
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 121, $this->source); })()), "user", [], "any", false, false, false, 121), "lastName", [], "any", false, false, false, 121), "html", null, true);
        echo "!</span>
                                    <img src=\"";
        // line 122
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/user-image.png"), "html", null, true);
        echo "\" alt=\"user\" class=\"img-circle\">
                                </a>
                                <div class=\"dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown \" aria-labelledby=\"Preview\">
                                    <!-- item-->
                                    <div class=\"dropdown-item noti-title\">
                                        <h5 class=\"text-overflow\">
                                            <small>";
        // line 128
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 128, $this->source); })()), "user", [], "any", false, false, false, 128), "firstName", [], "any", false, false, false, 128), "html", null, true);
        echo "
                                                ";
        // line 129
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 129, $this->source); })()), "user", [], "any", false, false, false, 129), "lastName", [], "any", false, false, false, 129), "html", null, true);
        echo "</small>
                                        </h5>
                                    </div>

                                    ";
        // line 133
        if (($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN") || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 133, $this->source); })()), "hasRole", [0 => "ROLE_ADMIN"], "method", false, false, false, 133))) {
            // line 134
            echo "                                        <a data-ng-if=\"billingPortalLink\" data-ng-href=\"{[billingPortalLink]}\" class=\"dropdown-item notify-item\">
                                            <i class=\"zmdi zmdi-account-o\"></i>
                                            <span>Update Billing</span>
                                        </a>
                                    ";
        }
        // line 139
        echo "                                </a>
                                <a data-ng-if=\"companyId == 79\" data-ng-click=\"resetDemo()\" href=\"javascript:void(0);\" class=\"dropdown-item notify-item\">
                                    <i class=\"zmdi zmdi-power\"></i>
                                    <span>Reset Demo</span>
                                </a>
                                
                                <a href=\"";
        // line 145
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_security_logout");
        echo "\" class=\"dropdown-item notify-item\">
                                    <i class=\"zmdi zmdi-power\"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                </div>
                <!-- end menu-extras -->
                <div class=\"clearfix\"></div>

            </div>
            <!-- end container -->
        </div>
        <!-- end topbar-main -->

        <div class=\"navbar-custom\">
            <div class=\"container\">
                <div id=\"navigation\">
                    <!-- Navigation Menu-->
                    <ul class=\"navigation-menu\">
                        ";
        // line 173
        echo "
                        <li class=\"";
        // line 174
        if ((($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN") || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 174, $this->source); })()), "hasRole", [0 => "ROLE_ACCOUNTANT"], "method", false, false, false, 174)) == false)) {
            echo "invisible";
        }
        echo " accountant-link\">
                            <a href=\"";
        // line 175
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("showCompanyAccountantDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 175, $this->source); })())]), "html", null, true);
        echo "\">
                                <i class=\"zmdi zmdi-account\"></i>
                                <span>
                                    Accountant
                                </span>
                            </a>
                        </li>
                        <li class=\"";
        // line 182
        if ((($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN") || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 182, $this->source); })()), "hasRole", [0 => "ROLE_APPROVER"], "method", false, false, false, 182)) == false)) {
            echo "invisible";
        }
        echo " approver-link\">
                            <a href=\"";
        // line 183
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("showCompanyApproverDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 183, $this->source); })())]), "html", null, true);
        echo "\">
                                <i class=\"zmdi zmdi-account\"></i>
                                <span>
                                    Approver
                                </span>
                            </a>
                        </li>
                        <!--<li> <a href=\"/dashboard/accountant\"><i class=\"zmdi zmdi-account\"></i> <span> Accountant </span> </a> </li> <li> <a href=\"/dashboard/approver\"><i class=\"zmdi zmdi-account\"></i> <span> Approver </span> </a> </li> -->
                        ";
        // line 212
        echo "
                    </ul>
                    <button type=\"button\" onclick=\"openHelp()\" class=\"btn btn-outline-dark btn-rounded waves-effect waves-light pull-right\" style=\"padding: 5px 17px;margin-top: 11px;margin-left: 20px;background: transparent;border: solid 1px #000;font-size: 20px;\">
                        ?
                    </button>
                    <div class=\"btn-group pull-right m-t-15\">
                        <button type=\"button\" style=\"background: #FFF;border: solid 1px #ccc;\" class=\"btn bg-white border dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                            <i class=\"fa fa-bell\"></i>
                            Reminders<span class=\"caret\"></span>
                        </button>
                        <div class=\"dropdown-menu\">
                            ";
        // line 223
        if ((($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN") || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 223, $this->source); })()), "hasRole", [0 => "ROLE_ACCOUNTANT"], "method", false, false, false, 223)) || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 223, $this->source); })()), "hasRole", [0 => "ROLE_APPROVER"], "method", false, false, false, 223))) {
            // line 224
            echo "                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#sendReminderNowApproversModal\">Send Reminder Now (Approvers)</a>
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#sendReminderNowPurchasersModal\">Send Reminder Now (Purchasers)</a>
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#scheduleReminderApproversModal\">Schedule Reminders (Approvers)</a>
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#scheduleReminderPurchasersModal\">Schedule Reminders (Purchasers)</a>
                            ";
        }
        // line 229
        echo "                        </div>
                    </div>

                    ";
        // line 232
        if (($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN") || twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 232, $this->source); })()), "hasRole", [0 => "ROLE_ADMIN"], "method", false, false, false, 232))) {
            // line 233
            echo "                        <div class=\"admin-link btn-group pull-right m-t-15\">
                            <button type=\"button\" style=\"background: #FFF;border: solid 1px #ccc; margin-right: 10px;\" class=\"btn bg-white border dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                                <i class=\"fa fa-gear\"></i>
                                Administration<span class=\"caret\"></span></button>
                            <div class=\"dropdown-menu\">
                                <a class=\"dropdown-item\" href=\"";
            // line 238
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("showCompanyAccountDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 238, $this->source); })())]), "html", null, true);
            echo "\">Account</a>         
                                ";
            // line 240
            echo "                                <a class=\"dropdown-item\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("classesCompanyDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 240, $this->source); })())]), "html", null, true);
            echo "\">Classes</a>
                                ";
            // line 242
            echo "                                <a class=\"dropdown-item\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("dashboardAdminUsersCompanyPage", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 242, $this->source); })())]), "html", null, true);
            echo "\">Users</a>
                                <a class=\"dropdown-item\" href=\"";
            // line 243
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("showCompanyAdminDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 243, $this->source); })())]), "html", null, true);
            echo "\">Jobs, Items & Accounts</a>
                                <a class=\"dropdown-item\" href=\"";
            // line 244
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("showCompanyPaymentTypesDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 244, $this->source); })())]), "html", null, true);
            echo "\">Payment Types</a>
                                ";
            // line 246
            echo "                                <a class=\"dropdown-item\" href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("vendorsCompanyDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 246, $this->source); })())]), "html", null, true);
            echo "\">Vendors</a>                                
                                ";
            // line 248
            echo "                                ";
            // line 249
            echo "                                ";
            // line 250
            echo "                                ";
            if ( !$this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN")) {
                // line 251
                echo "                                    <a class=\"dropdown-item\" href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("showSetupWizardDashboard", ["id" => (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 251, $this->source); })()), "employeeId" => twig_get_attribute($this->env, $this->source, (isset($context["employeeRecord"]) || array_key_exists("employeeRecord", $context) ? $context["employeeRecord"] : (function () { throw new RuntimeError('Variable "employeeRecord" does not exist.', 251, $this->source); })()), "id", [], "any", false, false, false, 251)]), "html", null, true);
                echo "\">Open Set-Up Wizard</a>
                                ";
            }
            // line 253
            echo "                                ";
            // line 254
            echo "                            </div>
                        </div>
                        <input type=\"hidden\" id=\"isAdmin\" value=\"true\"/>
                    ";
        }
        // line 258
        echo "
                    <!-- End navigation menu -->
                </div>
            </div>
        </div>
    </header>
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class=\"wrapper\">
        <div class=\"container\">

            <!-- Page-Title -->
            <div class=\"row\">
                <div class=\"col-sm-12\">

                    ";
        // line 291
        echo "                    <h4 class=\"page-title\">
                        ";
        // line 292
        $this->displayBlock('pageheader', $context, $blocks);
        // line 293
        echo "                    </h4>
                </div>
            </div>

            ";
        // line 297
        $this->displayBlock('body', $context, $blocks);
        // line 298
        echo "
            <!-- Footer -->
            <footer class=\"footer text-right\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-xs-12\">
                            2017 © ProjectPro.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->

        </div>
        <!-- container -->

        <!-- Right Sidebar -->
        <!-- <div class=\"side-bar right-bar\"> <div class=\"nicescroll\"> <ul class=\"nav nav-tabs text-xs-center\"> <li class=\"nav-item\"> <a href=\"#home-2\" class=\"nav-link active\" data-toggle=\"tab\" aria-expanded=\"false\"> Activity </a> </li> <li class=\"nav-item\"> <a href=\"#messages-2\" class=\"nav-link\" data-toggle=\"tab\" aria-expanded=\"true\"> Settings </a> </li> </ul> <div class=\"tab-content\"> <div class=\"tab-pane fade in active\" id=\"home-2\"> <div class=\"timeline-2\"> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">5 minutes ago</small> <p><strong><a href=\"#\" class=\"text-info\">John Doe</a></strong> Uploaded a photo <strong>\"DSC000586.jpg\"</strong></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">30 minutes ago</small> <p><a href=\"\" class=\"text-info\">Lorem</a> commented your post.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">59 minutes ago</small> <p><a href=\"\" class=\"text-info\">Jessi</a> attended a meeting with<a href=\"#\" class=\"text-success\">John Doe</a>.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">1 hour ago</small> <p><strong><a href=\"#\" class=\"text-info\">John Doe</a></strong>Uploaded 2 new photos</p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">3 hours ago</small> <p><a href=\"\" class=\"text-info\">Lorem</a> commented your post.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">5 hours ago</small> <p><a href=\"\" class=\"text-info\">Jessi</a> attended a meeting with<a href=\"#\" class=\"text-success\">John Doe</a>.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> </div> </div> <div class=\"tab-pane fade\" id=\"messages-2\"> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">Notifications</h5> <p class=\"text-muted m-b-0\"><small>Do you need them?</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">API Access</h5> <p class=\"m-b-0 text-muted\"><small>Enable/Disable access</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">Auto Updates</h5> <p class=\"m-b-0 text-muted\"><small>Keep up to date</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">Online Status</h5> <p class=\"m-b-0 text-muted\"><small>Show your status to all</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> </div> </div> </div> </div> -->
        <!-- /Right-bar -->

    </div>
    <!-- End wrapper -->
    <div data-ng-controller=\"CreateCompanyController\">
        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"newCompanyModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">New Company</h5>
                    </div>
                    <div class=\"modal-body\">
                        <div class=\"form-group row\">
                            <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" data-ng-model=\"companyName\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" data-ng-click=\"addCompany()\" class=\"btn btn-primary\">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Credit Card Controller Here, now moved to account.html.twig -->

    <div data-ng-controller=\"ReminderController\">
        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"sendReminderNowPurchasersModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Send Reminder to Purchasers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"sendReminderPurchasers()\">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"sendReminderNowApproversModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Send Reminder to Approvers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"sendReminderApprovers()\">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"scheduleReminderPurchasersModal\" data-ng-init=\"getScheduledRemindersPurchaser()\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Schedule Reminder to Purchasers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\">Days</label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\" data-ng-repeat=\"role in listDaysP\">
                                        <input id=\"role{[role.name]}\" name=\"role{[role.name]}\" data-ng-model=\"role.checked\" type=\"checkbox\">
                                        <label for=\"role{[role.name]}\">
                                            {[role.name]}
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"scheduleReminderPurchasers()\">
                            Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"scheduleReminderApproversModal\" data-ng-init=\"getScheduledRemindersApprover()\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Schedule Reminder to Approvers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\">Days</label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\" data-ng-repeat=\"role in listDaysA\">
                                        <input id=\"role{[role.name]}\" name=\"role{[role.name]}\" data-ng-model=\"role.checked\" type=\"checkbox\">
                                        <label for=\"role{[role.name]}\">
                                            {[role.name]}
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"scheduleReminderApprovers()\">Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" modal-window=\"modal-window\" tabindex=\"-1\" role=\"document\" id=\"helpModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">About this Page</h5>
                        <div class=\"dialog-close\">x</div>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\" style=\"top: -20px;position: relative;\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        ";
        // line 512
        if ((isset($context["helpcontent"]) || array_key_exists("helpcontent", $context))) {
            echo twig_escape_filter($this->env, (isset($context["helpcontent"]) || array_key_exists("helpcontent", $context) ? $context["helpcontent"] : (function () { throw new RuntimeError('Variable "helpcontent" does not exist.', 512, $this->source); })()), "html", null, true);
            echo "
                        ";
        }
        // line 514
        echo "                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">Got it!</button>
                    </div>
                </div>
            </div>
        </div>

        <div data-ng-controller=\"ExpiredController\" class=\"modal fade bs-example-modal-sm\" modal-window=\"modal-window\" tabindex=\"-1\" role=\"document\" id=\"expiredModalAdmin\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">ACCOUNT EXPIRED</h5>
                    </div>
                    <div class=\"modal-body\">
                        <h5 style=\"
                        text-align: center;
                        text-transform: uppercase;
                        \">No valid credit card on file. As administrator please click on the button below to update your account.</h5>
                    </div>
                    <div class=\"modal-footer\">
                        <a href=\"/dashboard/company/";
        // line 535
        echo twig_escape_filter($this->env, (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 535, $this->source); })()), "html", null, true);
        echo "/account?error=Please%20Edit%20Billing%20Info%20to%20continue%20using%20ProjectPro\">
                            <button type=\"button\" class=\"btn btn-primary\">Update Billing Now
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" modal-window=\"modal-window\" tabindex=\"-1\" role=\"document\" id=\"expiredModalUser\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">ACCOUNT EXPIRED</h5>
                    </div>
                    <div class=\"modal-body\">
                        <h5 style=\"
                        text-align: center;
                        text-transform: uppercase;
                        \">No valid credit card on file. Please ask a company Administrator to log into ProjectPro and enter a valid credit card.</h5>
                    </div>
                    <div class=\"modal-footer\">
                        <a href=\"";
        // line 557
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_security_logout");
        echo "\">
                            <button type=\"button\" class=\"btn btn-primary\">Logout
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #setupWizard {
                height: 500px;
                width: 400px;
                background: #ccc;
                position: absolute;
                top: 100px;
                right: 20px;
                z-index: 9999;
            }

            #setupWizard .head {
                background: #3c6bb7;
                color: #FFF;
                height: 40px;
                text-align: center;
                padding-top: 8px;
            }

            #setupWizard .content {
                padding: 10px;
                min-height: 400px;
            }

            #setupWizard .foot {
                background: #eceeef;
                height: 60px;
                border: 1px solid #bfbfbf;
                padding: 10px;
            }
        </style>
        <!-- <div id=\"setupWizard\"> <div class=\"head\"> <h4>Setup Wizard</h4> </div> <div class=\"content\"> <p>Welcome to the setup wizard</p> </div> <div class=\"foot\"> <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button> <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"scheduleReminderApprovers()\">Schedule</button> </div> </div> -->

    </div>

    <script>
        var resizefunc = [];
        var applicationUserId = '";
        // line 603
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 603, $this->source); })()), "user", [], "any", false, false, false, 603), "id", [], "any", false, false, false, 603), "html", null, true);
        echo "';
        //\$(\"#setupWizard\").draggable({
        //    handle: \"#setupWizard .head\"
        //});
    </script>

    <!-- jQuery -->
    <script src=\"";
        // line 610
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 611
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/tether.min.js"), "html", null, true);
        echo "\"></script>
    <!-- Tether for Bootstrap -->
    <script src=\"";
        // line 613
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 614
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/waves.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 615
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.nicescroll.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 616
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery-ui.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 617
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/switchery/switchery.min.js"), "html", null, true);
        echo "\"></script>

    <!--Morris Chart-->
    <script src=\"";
        // line 620
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/morris/morris.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 621
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/morris/morris.min.js"), "html", null, true);
        echo "\"></script>

    <!-- Counter Up -->
    <script src=\"";
        // line 624
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/morris/morris.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 625
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/counterup/jquery.counterup.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 626
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/toastr/toastr.min.js"), "html", null, true);
        echo "\"></script>

    <!-- App js -->
    <script src=\"";
        // line 629
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.core.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 630
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.app.js"), "html", null, true);
        echo "\"></script>
    <!-- responsive-table-->
    <script src=\"";
        // line 632
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/RWD-Table-Patterns/js/rwd-table.min.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>

    <script src=\"";
        // line 634
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular/angular.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 635
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/moment/min/moment.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 636
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/bootstrap-datepicker.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 637
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.priceformat.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 638
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/ekko-lightbox/dist/ekko-lightbox.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 639
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular-fcsa-number/src/fcsaNumber.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 640
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular-ui-select/dist/select.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 641
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular-sanitize/angular-sanitize.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 642
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 643
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/angular-loading/loading-bar.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 644
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/drift/dist/Drift.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 645
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("bower_components/jquery-form/jquery.form.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 646
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("core/application.js"), "html", null, true);
        echo "\"></script>

    <script>
        ";
        // line 649
        if ((((isset($context["error"]) || array_key_exists("error", $context)) &&  !(null === (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 649, $this->source); })()))) &&  !twig_test_empty((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 649, $this->source); })())))) {
            // line 650
            echo "            toastr.error('";
            echo twig_escape_filter($this->env, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 650, $this->source); })()), "html", null, true);
            echo "', 'Payment Failed');
        ";
        }
        // line 652
        echo "        \$('img').error(function () {
            \$(this).attr('src', '";
        // line 653
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/missing_image.png"), "html", null, true);
        echo "' );
        });        
    </script>

    ";
        // line 657
        $this->displayBlock('javascripts', $context, $blocks);
        // line 658
        echo "</body>
</html>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 10
    public function block_title($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Project Pro";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 12
    public function block_stylesheets($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 292
    public function block_pageheader($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageheader"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageheader"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 297
    public function block_body($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 657
    public function block_javascripts($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1022 => 657,  1005 => 297,  988 => 292,  971 => 12,  953 => 10,  942 => 658,  940 => 657,  933 => 653,  930 => 652,  924 => 650,  922 => 649,  916 => 646,  912 => 645,  908 => 644,  904 => 643,  900 => 642,  896 => 641,  892 => 640,  888 => 639,  884 => 638,  880 => 637,  876 => 636,  872 => 635,  868 => 634,  863 => 632,  858 => 630,  854 => 629,  848 => 626,  844 => 625,  840 => 624,  834 => 621,  830 => 620,  824 => 617,  820 => 616,  816 => 615,  812 => 614,  808 => 613,  803 => 611,  799 => 610,  789 => 603,  740 => 557,  715 => 535,  692 => 514,  686 => 512,  470 => 298,  468 => 297,  462 => 293,  460 => 292,  457 => 291,  437 => 258,  431 => 254,  429 => 253,  423 => 251,  420 => 250,  418 => 249,  416 => 248,  411 => 246,  407 => 244,  403 => 243,  398 => 242,  393 => 240,  389 => 238,  382 => 233,  380 => 232,  375 => 229,  368 => 224,  366 => 223,  353 => 212,  342 => 183,  336 => 182,  326 => 175,  320 => 174,  317 => 173,  290 => 145,  282 => 139,  275 => 134,  273 => 133,  266 => 129,  262 => 128,  253 => 122,  249 => 121,  245 => 120,  220 => 97,  218 => 96,  216 => 95,  214 => 94,  212 => 93,  210 => 92,  208 => 91,  206 => 90,  203 => 88,  199 => 86,  197 => 85,  182 => 73,  172 => 66,  156 => 53,  150 => 50,  127 => 30,  122 => 28,  118 => 27,  114 => 26,  110 => 25,  106 => 24,  101 => 22,  97 => 21,  93 => 20,  89 => 19,  85 => 18,  81 => 17,  77 => 16,  73 => 15,  69 => 14,  64 => 13,  62 => 12,  59 => 11,  57 => 10,  46 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\"/>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"description\" content=\"Project Pro\">
        <meta name=\"author\" content=\"Harold Ocampo\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <title>
            {% block title %}Project Pro{% endblock %}
        </title>
        {% block stylesheets %}{% endblock %}
        <link rel=\"icon\" type=\"image/x-icon\" href=\"{{ asset('images/pprologo.png') }}\"/>
        <link href=\"{{ asset('uplon/assets/plugins/toastr/toastr.min.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"{{ asset('uplon/assets/plugins/morris/morris.css') }}\">
        <link href=\"{{ asset('uplon/assets/plugins/switchery/switchery.min.css') }}\" rel=\"stylesheet\"/>
        <link href=\"{{ asset('uplon/assets/css/bootstrap-datepicker.min.css') }}\" rel=\"stylesheet\"/>
        <link href=\"{{ asset('uplon/assets/css/style.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"{{ asset('uplon/assets/public/stylesheets/style.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"{{ asset('bower_components/ekko-lightbox/dist/ekko-lightbox.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"{{ asset('bower_components/angular-ui-select/dist/select.min.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"{{ asset('font-awesome/css/font-awesome.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
        <link href=\"{{ asset('uplon/assets/css/overrides.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <link rel=\"stylesheet\" href=\"{{ asset('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') }}\"/>
        <link rel=\"stylesheet\" href=\"{{ asset('bower_components/angular-loading/loading-bar.css') }}\"/>
        <link rel=\"stylesheet\" href=\"{{ asset('bower_components/drift/dist/Drift.min.js') }}\"/>
        <script src=\"{{ asset('uplon/assets/js/modernizr.min.js') }}\"></script>
        <!--[if !IE]><!-->
        <link href=\"{{ asset('uplon/assets/css/ie-overrides.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
        <!--<![endif]-->
        <style>
            .ng-cloak,
            .x-ng-cloak,
            [data-ng-cloak],
            [ng-cloak],
            [ng\\:cloak],
            [x-ng-cloak] {
                display: none !important;
            }
            .click{
                cursor: pointer;
            }
        </style>

        <!-- link to the SqPaymentForm library -->
        <script type=\"text/javascript\" src=\"https://js.squareup.com/v2/paymentform\"></script>

        <!-- link to the local SqPaymentForm initialization -->
        <script type=\"text/javascript\" src=\"{{ asset('sqpayment/sqpaymentform.js') }}\"></script>

        <!-- link to the custom styles for SqPaymentForm -->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"{{ asset('sqpayment/sqpaymentform.css') }}\">

    </head>
    <body data-ng-app=\"ProjexApp\" class=\"ng-cloak\">

        <!-- Navigation Bar-->
        <header id=\"topnav\">
            <div class=\"topbar-main\">
                <div data-ng-controller=\"CompanyController\" class=\"container relative\">

                    <!-- LOGO -->
                    <div class=\"topbar-left\">
                        <a href=\"#\" class=\"logo\">
                            <img src=\"{{ asset('images/logo-web-banner.png') }}\"/>
                        </a>
                    </div>

                    <div style=\"display: none;\">
                        <div class=\"upgrade-section\">
                            <span data-ng-if=\"!processingPayment\">{[trialDaysLeft]} Days Left in Free Trial</span>
                            <a href=\"/dashboard/company/{{ companyId }}/account\">
                                <button data-ng-if=\"!processingPayment\" data-toggle=\"modal\" data-target=\"#creditCartModal\">UPGRADE NOW</button>
                            </a>
                            <span data-ng-if=\"processingPayment\">Processing Payment</span>

                        </div>
                    </div>

                    <div data-ng-controller=\"CompaniesController\" class=\"btn-group company-section\" style=\"\">
                        <button type=\"button\" style=\"\" class=\"btn bg-white border dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">{[ selectedCompany ]}<span class=\"caret\" style=\"margin-left: 7px;\"></span>
                        </button>
                        <div class=\"dropdown-menu\" style=\"overflow: scroll; height: auto; max-height: 350px;\">
                            {% if is_granted('ROLE_ADMIN') or employeeRecord.hasRole('ROLE_ADMIN') %}
                                <a class=\"dropdown-item\" style=\"color: #FFF;background: #315da6;\" data-toggle=\"modal\" data-target=\"#newCompanyModal\">Create New Company</a>
                            {% endif %}
                            <a class=\"dropdown-item\" data-ng-repeat=\"c in companies\" data-ng-href=\"/dashboard/company/{[ c.id ]}\">{[ c.name ]}</a>
                            {#{% if employeeRecord.hasRole('ROLE_ADMIN') %}#}
                            {#<a class=\"dropdown-item\" data-ng-repeat=\"c in companies\" data-ng-href=\"/dashboard/company/{[ c.id ]}\">{[ c.name ]}</a>#}
                            {#{% elseif employeeRecord.hasRole('ROLE_APPROVER') %}#}
                            {#<a class=\"dropdown-item\" data-ng-repeat=\"c in companies\" data-ng-href=\"/dashboard/company/{[ c.id ]}\">{[ c.name ]}</a>#}
                            {#{% elseif employeeRecord.hasRole('ROLE_ACCOUNTANT') %}#}
                            {#<a class=\"dropdown-item\" data-ng-repeat=\"c in companies\" data-ng-href=\"/dashboard/company/{[ c.id ]}\">{[ c.name ]}</a>#}
                            {#{% endif %}#}
                            {#<a class=\"dropdown-item\" style=\"color: #FFF;background: #315da6;\" data-toggle=\"modal\" data-target=\"#newCompanyModal\" >Create New Company</a>#}
                        </div>
                    </div>
                    <!-- End Logo container-->

                    <div class=\"menu-extras\">

                        <ul class=\"nav navbar-nav pull-right\">

                            <li class=\"nav-item\">
                                <!-- Mobile menu toggle-->
                                <a class=\"navbar-toggle\">
                                    <div class=\"lines\">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                            <li class=\"nav-item dropdown notification-list\" data-ng-controller=\"MenuController\">
                                <a class=\"nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"false\" aria-expanded=\"false\">
                                    <span class=\"hello-name\">Hello
                                        {{ app.user.firstName }}
                                        {{ app.user.lastName }}!</span>
                                    <img src=\"{{ asset('images/user-image.png') }}\" alt=\"user\" class=\"img-circle\">
                                </a>
                                <div class=\"dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown \" aria-labelledby=\"Preview\">
                                    <!-- item-->
                                    <div class=\"dropdown-item noti-title\">
                                        <h5 class=\"text-overflow\">
                                            <small>{{ app.user.firstName }}
                                                {{ app.user.lastName }}</small>
                                        </h5>
                                    </div>

                                    {% if is_granted('ROLE_ADMIN') or employeeRecord.hasRole('ROLE_ADMIN') %}
                                        <a data-ng-if=\"billingPortalLink\" data-ng-href=\"{[billingPortalLink]}\" class=\"dropdown-item notify-item\">
                                            <i class=\"zmdi zmdi-account-o\"></i>
                                            <span>Update Billing</span>
                                        </a>
                                    {% endif %}
                                </a>
                                <a data-ng-if=\"companyId == 79\" data-ng-click=\"resetDemo()\" href=\"javascript:void(0);\" class=\"dropdown-item notify-item\">
                                    <i class=\"zmdi zmdi-power\"></i>
                                    <span>Reset Demo</span>
                                </a>
                                
                                <a href=\"{{ path('fos_user_security_logout') }}\" class=\"dropdown-item notify-item\">
                                    <i class=\"zmdi zmdi-power\"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                </div>
                <!-- end menu-extras -->
                <div class=\"clearfix\"></div>

            </div>
            <!-- end container -->
        </div>
        <!-- end topbar-main -->

        <div class=\"navbar-custom\">
            <div class=\"container\">
                <div id=\"navigation\">
                    <!-- Navigation Menu-->
                    <ul class=\"navigation-menu\">
                        {#<li>
                            <a href=\"{{ path('dashboardPage') }}\"><i class=\"zmdi zmdi-view-dashboard\"></i>
                                <span> Dashboard </span> </a>
                        </li>#}

                        <li class=\"{% if (is_granted('ROLE_ADMIN') or employeeRecord.hasRole('ROLE_ACCOUNTANT')) == false %}invisible{% endif %} accountant-link\">
                            <a href=\"{{ path('showCompanyAccountantDashboard', {'id': companyId}) }}\">
                                <i class=\"zmdi zmdi-account\"></i>
                                <span>
                                    Accountant
                                </span>
                            </a>
                        </li>
                        <li class=\"{% if (is_granted('ROLE_ADMIN') or employeeRecord.hasRole('ROLE_APPROVER')) == false %}invisible{% endif %} approver-link\">
                            <a href=\"{{ path('showCompanyApproverDashboard', {'id': companyId}) }}\">
                                <i class=\"zmdi zmdi-account\"></i>
                                <span>
                                    Approver
                                </span>
                            </a>
                        </li>
                        <!--<li> <a href=\"/dashboard/accountant\"><i class=\"zmdi zmdi-account\"></i> <span> Accountant </span> </a> </li> <li> <a href=\"/dashboard/approver\"><i class=\"zmdi zmdi-account\"></i> <span> Approver </span> </a> </li> -->
                        {#
                                                    <li class=\"has-submenu\">
                                                        <a href=\"#\"><i class=\"zmdi zmdi-format-underlined\"></i> <span> User Interface </span> </a>
                                                        <ul class=\"submenu megamenu\">
                                                            <li>
                                                                <ul>
                                                                    <li><a href=\"ui-buttons.html\">Buttons</a></li>
                                                                    <li><a href=\"ui-cards.html\">Cards</a></li>
                                                                    <li><a href=\"ui-dropdowns.html\">Dropdowns</a></li>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                                <ul>
                                                                    <li><a href=\"ui-notification.html\">Notification</a></li>
                                                                    <li><a href=\"ui-carousel.html\">Carousel</a></li>
                                                                    <li><a href=\"components-grid.html\">Grid</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                        #}

                    </ul>
                    <button type=\"button\" onclick=\"openHelp()\" class=\"btn btn-outline-dark btn-rounded waves-effect waves-light pull-right\" style=\"padding: 5px 17px;margin-top: 11px;margin-left: 20px;background: transparent;border: solid 1px #000;font-size: 20px;\">
                        ?
                    </button>
                    <div class=\"btn-group pull-right m-t-15\">
                        <button type=\"button\" style=\"background: #FFF;border: solid 1px #ccc;\" class=\"btn bg-white border dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                            <i class=\"fa fa-bell\"></i>
                            Reminders<span class=\"caret\"></span>
                        </button>
                        <div class=\"dropdown-menu\">
                            {% if is_granted('ROLE_ADMIN') or employeeRecord.hasRole('ROLE_ACCOUNTANT') or employeeRecord.hasRole('ROLE_APPROVER') %}
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#sendReminderNowApproversModal\">Send Reminder Now (Approvers)</a>
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#sendReminderNowPurchasersModal\">Send Reminder Now (Purchasers)</a>
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#scheduleReminderApproversModal\">Schedule Reminders (Approvers)</a>
                                <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#scheduleReminderPurchasersModal\">Schedule Reminders (Purchasers)</a>
                            {% endif %}
                        </div>
                    </div>

                    {% if is_granted('ROLE_ADMIN') or employeeRecord.hasRole('ROLE_ADMIN') %}
                        <div class=\"admin-link btn-group pull-right m-t-15\">
                            <button type=\"button\" style=\"background: #FFF;border: solid 1px #ccc; margin-right: 10px;\" class=\"btn bg-white border dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                                <i class=\"fa fa-gear\"></i>
                                Administration<span class=\"caret\"></span></button>
                            <div class=\"dropdown-menu\">
                                <a class=\"dropdown-item\" href=\"{{ path('showCompanyAccountDashboard', {'id': companyId}) }}\">Account</a>         
                                {# {% if isQbIntegrated %}                   #}
                                <a class=\"dropdown-item\" href=\"{{ path('classesCompanyDashboard', {'id': companyId}) }}\">Classes</a>
                                {# {% endif %} #}
                                <a class=\"dropdown-item\" href=\"{{ path('dashboardAdminUsersCompanyPage', {'id': companyId}) }}\">Users</a>
                                <a class=\"dropdown-item\" href=\"{{ path('showCompanyAdminDashboard', {'id': companyId}) }}\">Jobs, Items & Accounts</a>
                                <a class=\"dropdown-item\" href=\"{{ path('showCompanyPaymentTypesDashboard', {'id': companyId}) }}\">Payment Types</a>
                                {# {% if isQbIntegrated %} #}
                                <a class=\"dropdown-item\" href=\"{{ path('vendorsCompanyDashboard', {'id': companyId}) }}\">Vendors</a>                                
                                {# <a class=\"dropdown-item\" href=\"{{ path('apiExportQbExceptions', {'id': companyId}) }}\">QB Errors</a>                                 #}
                                {# {% endif %} #}
                                {#% if app.user.isDoneWizard %#}
                                {% if not is_granted('ROLE_ADMIN') %}
                                    <a class=\"dropdown-item\" href=\"{{ path('showSetupWizardDashboard', {'id': companyId, 'employeeId': employeeRecord.id}) }}\">Open Set-Up Wizard</a>
                                {% endif %}
                                {#% endif %#}
                            </div>
                        </div>
                        <input type=\"hidden\" id=\"isAdmin\" value=\"true\"/>
                    {% endif %}

                    <!-- End navigation menu -->
                </div>
            </div>
        </div>
    </header>
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class=\"wrapper\">
        <div class=\"container\">

            <!-- Page-Title -->
            <div class=\"row\">
                <div class=\"col-sm-12\">

                    {#
                <div class=\"btn-group pull-right m-t-15\">
                    <button type=\"button\" class=\"btn btn-custom dropdown-toggle waves-effect waves-light\"
                            data-toggle=\"dropdown\" aria-expanded=\"false\">Actions <span class=\"m-l-5\"><i
                                class=\"fa fa-cog\"></i></span></button>
                    <div class=\"dropdown-menu\">
    
    
                        <!--a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#sendRecurringReminderModal\">Schedule Recurring Reminder</a-->
    
                        <a class=\"dropdown-item\" href=\"#\">Help (About this page)</a>
                    </div>
    
                </div>
                    #}
                    <h4 class=\"page-title\">
                        {% block pageheader %}{% endblock %}
                    </h4>
                </div>
            </div>

            {% block body %}{% endblock %}

            <!-- Footer -->
            <footer class=\"footer text-right\">
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-xs-12\">
                            2017 © ProjectPro.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->

        </div>
        <!-- container -->

        <!-- Right Sidebar -->
        <!-- <div class=\"side-bar right-bar\"> <div class=\"nicescroll\"> <ul class=\"nav nav-tabs text-xs-center\"> <li class=\"nav-item\"> <a href=\"#home-2\" class=\"nav-link active\" data-toggle=\"tab\" aria-expanded=\"false\"> Activity </a> </li> <li class=\"nav-item\"> <a href=\"#messages-2\" class=\"nav-link\" data-toggle=\"tab\" aria-expanded=\"true\"> Settings </a> </li> </ul> <div class=\"tab-content\"> <div class=\"tab-pane fade in active\" id=\"home-2\"> <div class=\"timeline-2\"> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">5 minutes ago</small> <p><strong><a href=\"#\" class=\"text-info\">John Doe</a></strong> Uploaded a photo <strong>\"DSC000586.jpg\"</strong></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">30 minutes ago</small> <p><a href=\"\" class=\"text-info\">Lorem</a> commented your post.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">59 minutes ago</small> <p><a href=\"\" class=\"text-info\">Jessi</a> attended a meeting with<a href=\"#\" class=\"text-success\">John Doe</a>.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">1 hour ago</small> <p><strong><a href=\"#\" class=\"text-info\">John Doe</a></strong>Uploaded 2 new photos</p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">3 hours ago</small> <p><a href=\"\" class=\"text-info\">Lorem</a> commented your post.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> <div class=\"time-item\"> <div class=\"item-info\"> <small class=\"text-muted\">5 hours ago</small> <p><a href=\"\" class=\"text-info\">Jessi</a> attended a meeting with<a href=\"#\" class=\"text-success\">John Doe</a>.</p> <p><em>\"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam laoreet tellus ut tincidunt euismod. \"</em></p> </div> </div> </div> </div> <div class=\"tab-pane fade\" id=\"messages-2\"> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">Notifications</h5> <p class=\"text-muted m-b-0\"><small>Do you need them?</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">API Access</h5> <p class=\"m-b-0 text-muted\"><small>Enable/Disable access</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">Auto Updates</h5> <p class=\"m-b-0 text-muted\"><small>Keep up to date</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> <div class=\"row m-t-20\"> <div class=\"col-xs-8\"> <h5 class=\"m-0\">Online Status</h5> <p class=\"m-b-0 text-muted\"><small>Show your status to all</small></p> </div> <div class=\"col-xs-4 text-right\"> <input type=\"checkbox\" checked data-plugin=\"switchery\" data-color=\"#64b0f2\" data-size=\"small\"/> </div> </div> </div> </div> </div> </div> -->
        <!-- /Right-bar -->

    </div>
    <!-- End wrapper -->
    <div data-ng-controller=\"CreateCompanyController\">
        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"newCompanyModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">New Company</h5>
                    </div>
                    <div class=\"modal-body\">
                        <div class=\"form-group row\">
                            <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" data-ng-model=\"companyName\"/>
                            </div>
                        </div>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" data-ng-click=\"addCompany()\" class=\"btn btn-primary\">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Credit Card Controller Here, now moved to account.html.twig -->

    <div data-ng-controller=\"ReminderController\">
        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"sendReminderNowPurchasersModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Send Reminder to Purchasers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"sendReminderPurchasers()\">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"sendReminderNowApproversModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Send Reminder to Approvers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"sendReminderApprovers()\">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"scheduleReminderPurchasersModal\" data-ng-init=\"getScheduledRemindersPurchaser()\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Schedule Reminder to Purchasers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\">Days</label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\" data-ng-repeat=\"role in listDaysP\">
                                        <input id=\"role{[role.name]}\" name=\"role{[role.name]}\" data-ng-model=\"role.checked\" type=\"checkbox\">
                                        <label for=\"role{[role.name]}\">
                                            {[role.name]}
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"scheduleReminderPurchasers()\">
                            Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"scheduleReminderApproversModal\" data-ng-init=\"getScheduledRemindersApprover()\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Schedule Reminder to Approvers</h5>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <form>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\">
                                        <input id=\"checkbox21\" type=\"checkbox\" disabled=\"true\" checked=\"true\">
                                        <label for=\"checkbox21\">
                                            Send to All
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\">Days</label>
                                <div class=\"col-sm-10\">
                                    <div class=\"checkbox checkbox-primary\" data-ng-repeat=\"role in listDaysA\">
                                        <input id=\"role{[role.name]}\" name=\"role{[role.name]}\" data-ng-model=\"role.checked\" type=\"checkbox\">
                                        <label for=\"role{[role.name]}\">
                                            {[role.name]}
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                        <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"scheduleReminderApprovers()\">Schedule
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" modal-window=\"modal-window\" tabindex=\"-1\" role=\"document\" id=\"helpModal\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">About this Page</h5>
                        <div class=\"dialog-close\">x</div>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\" style=\"top: -20px;position: relative;\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        {% if helpcontent is defined %}{{ helpcontent }}
                        {% endif %}
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">Got it!</button>
                    </div>
                </div>
            </div>
        </div>

        <div data-ng-controller=\"ExpiredController\" class=\"modal fade bs-example-modal-sm\" modal-window=\"modal-window\" tabindex=\"-1\" role=\"document\" id=\"expiredModalAdmin\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">ACCOUNT EXPIRED</h5>
                    </div>
                    <div class=\"modal-body\">
                        <h5 style=\"
                        text-align: center;
                        text-transform: uppercase;
                        \">No valid credit card on file. As administrator please click on the button below to update your account.</h5>
                    </div>
                    <div class=\"modal-footer\">
                        <a href=\"/dashboard/company/{{ companyId }}/account?error=Please%20Edit%20Billing%20Info%20to%20continue%20using%20ProjectPro\">
                            <button type=\"button\" class=\"btn btn-primary\">Update Billing Now
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade bs-example-modal-sm\" modal-window=\"modal-window\" tabindex=\"-1\" role=\"document\" id=\"expiredModalUser\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"mySmallModalLabel\">ACCOUNT EXPIRED</h5>
                    </div>
                    <div class=\"modal-body\">
                        <h5 style=\"
                        text-align: center;
                        text-transform: uppercase;
                        \">No valid credit card on file. Please ask a company Administrator to log into ProjectPro and enter a valid credit card.</h5>
                    </div>
                    <div class=\"modal-footer\">
                        <a href=\"{{ path('fos_user_security_logout') }}\">
                            <button type=\"button\" class=\"btn btn-primary\">Logout
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #setupWizard {
                height: 500px;
                width: 400px;
                background: #ccc;
                position: absolute;
                top: 100px;
                right: 20px;
                z-index: 9999;
            }

            #setupWizard .head {
                background: #3c6bb7;
                color: #FFF;
                height: 40px;
                text-align: center;
                padding-top: 8px;
            }

            #setupWizard .content {
                padding: 10px;
                min-height: 400px;
            }

            #setupWizard .foot {
                background: #eceeef;
                height: 60px;
                border: 1px solid #bfbfbf;
                padding: 10px;
            }
        </style>
        <!-- <div id=\"setupWizard\"> <div class=\"head\"> <h4>Setup Wizard</h4> </div> <div class=\"content\"> <p>Welcome to the setup wizard</p> </div> <div class=\"foot\"> <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button> <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"scheduleReminderApprovers()\">Schedule</button> </div> </div> -->

    </div>

    <script>
        var resizefunc = [];
        var applicationUserId = '{{ app.user.id }}';
        //\$(\"#setupWizard\").draggable({
        //    handle: \"#setupWizard .head\"
        //});
    </script>

    <!-- jQuery -->
    <script src=\"{{ asset('uplon/assets/js/jquery.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/tether.min.js') }}\"></script>
    <!-- Tether for Bootstrap -->
    <script src=\"{{ asset('uplon/assets/js/bootstrap.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/waves.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/jquery.nicescroll.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/jquery-ui.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/switchery/switchery.min.js') }}\"></script>

    <!--Morris Chart-->
    <script src=\"{{ asset('uplon/assets/plugins/morris/morris.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/morris/morris.min.js') }}\"></script>

    <!-- Counter Up -->
    <script src=\"{{ asset('uplon/assets/plugins/morris/morris.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/counterup/jquery.counterup.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/toastr/toastr.min.js') }}\"></script>

    <!-- App js -->
    <script src=\"{{ asset('uplon/assets/js/jquery.core.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/jquery.app.js') }}\"></script>
    <!-- responsive-table-->
    <script src=\"{{ asset('uplon/assets/plugins/RWD-Table-Patterns/js/rwd-table.min.js') }}\" type=\"text/javascript\"></script>

    <script src=\"{{ asset('bower_components/angular/angular.js') }}\"></script>
    <script src=\"{{ asset('bower_components/moment/min/moment.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/bootstrap-datepicker.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/jquery.priceformat.js') }}\"></script>
    <script src=\"{{ asset('bower_components/ekko-lightbox/dist/ekko-lightbox.js') }}\"></script>
    <script src=\"{{ asset('bower_components/angular-fcsa-number/src/fcsaNumber.min.js') }}\"></script>
    <script src=\"{{ asset('bower_components/angular-ui-select/dist/select.js') }}\"></script>
    <script src=\"{{ asset('bower_components/angular-sanitize/angular-sanitize.min.js') }}\"></script>
    <script src=\"{{ asset('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') }}\"></script>
    <script src=\"{{ asset('bower_components/angular-loading/loading-bar.js') }}\"></script>
    <script src=\"{{ asset('bower_components/drift/dist/Drift.min.js') }}\"></script>
    <script src=\"{{ asset('bower_components/jquery-form/jquery.form.js') }}\"></script>
    <script src=\"{{ asset('core/application.js') }}\"></script>

    <script>
        {% if error is defined and error is not null and error is not empty %}
            toastr.error('{{ error }}', 'Payment Failed');
        {% endif %}
        \$('img').error(function () {
            \$(this).attr('src', '{{ asset(\"images/missing_image.png\") }}' );
        });        
    </script>

    {% block javascripts %}{% endblock %}
</body>
</html>", "base.html.twig", "/Applications/MAMP/htdocs/projectpro-web/app/Resources/views/base.html.twig");
    }
}
