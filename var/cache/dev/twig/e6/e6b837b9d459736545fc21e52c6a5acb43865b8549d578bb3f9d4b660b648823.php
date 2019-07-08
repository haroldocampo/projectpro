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

/* @FOSUser/Security/login.html.twig */
class __TwigTemplate_9af7885804254e89a6c3adef687f82249bb4cce93d47fb19a999c5ae4c6909ed extends \Twig\Template
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
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@FOSUser/Security/login.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@FOSUser/Security/login.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\"/>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"description\" content=\"Project Pro\">
        <meta name=\"author\" content=\"Harold Ocampo\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <title>";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    ";
        // line 10
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 11
        echo "    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/pprologo.png"), "html", null, true);
        echo "\"/>
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/morris/morris.css"), "html", null, true);
        echo "\">
    <link href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/switchery/switchery.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\"/>
    <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/css/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/public/stylesheets/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/css/overrides.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
    <script src=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/modernizr.min.js"), "html", null, true);
        echo "\"></script>
</head>
<body>


    <!-- Navigation Bar-->
    <header id=\"topnav\">
        <div class=\"topbar-main\">
            <div class=\"container\">

                <!-- LOGO -->
                <div class=\"topbar-left\">
                    <a href=\"#\" class=\"logo\">
                        <img src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo-web-banner.png"), "html", null, true);
        echo "\"/>
                    </a>
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


                    </ul>

                </div> <!-- end menu-extras -->
                <div class=\"clearfix\"></div>

            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->


        ";
        // line 81
        echo "    </header>
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class=\"wrapper\">
        <div class=\"container\">

            <!-- Page-Title -->
            <div class=\"row\">
                <div class=\"col-sm-12\">
                </div>
            </div>
            <div class=\"row m-t-20\">
                <div class=\"col-xs-12 col-lg-6 col-lg-offset-3\">
                    <div class=\"card-box\">

                        <h2 class=\"m-t-0 m-b-20\">Login</h2>
                        ";
        // line 100
        if ((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 100, $this->source); })())) {
            // line 101
            echo "                            ";
            // line 102
            echo "                            ";
            // line 103
            echo "                            ";
            // line 104
            echo "                            <div class=\"alert alert-danger\" role=\"alert\">
                                <strong>";
            // line 105
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 105, $this->source); })()), "messageKey", [], "any", false, false, false, 105), twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 105, $this->source); })()), "messageData", [], "any", false, false, false, 105), "security"), "html", null, true);
            echo "</strong>
                            </div>
                            ";
            // line 108
            echo "                        ";
        }
        // line 109
        echo "                        <form action=\"";
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_security_check");
        echo "\" method=\"post\">
                            ";
        // line 110
        if ((isset($context["csrf_token"]) || array_key_exists("csrf_token", $context) ? $context["csrf_token"] : (function () { throw new RuntimeError('Variable "csrf_token" does not exist.', 110, $this->source); })())) {
            // line 111
            echo "                                <input type=\"hidden\" name=\"_csrf_token\" value=\"";
            echo twig_escape_filter($this->env, (isset($context["csrf_token"]) || array_key_exists("csrf_token", $context) ? $context["csrf_token"] : (function () { throw new RuntimeError('Variable "csrf_token" does not exist.', 111, $this->source); })()), "html", null, true);
            echo "\" />
                            ";
        }
        // line 113
        echo "                            <div class=\"form-group row\">
                                <label for=\"email\" class=\"col-sm-2 form-control-label\">Email</label>
                                <div class=\"col-sm-10\">
                                    <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Email\"
                                           name=\"_username\"
                                           value=\"";
        // line 118
        echo twig_escape_filter($this->env, (isset($context["last_username"]) || array_key_exists("last_username", $context) ? $context["last_username"] : (function () { throw new RuntimeError('Variable "last_username" does not exist.', 118, $this->source); })()), "html", null, true);
        echo "\" required>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label for=\"inputPassword3\" class=\"col-sm-2 form-control-label\">Password</label>
                                <div class=\"col-sm-10\">
                                    <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\"
                                           name=\"_password\" required>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"pull-left\"><span>Don't have an account? <a href=\"";
        // line 131
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_registration_register");
        echo "\">Sign up!</a></span>       
                                        <h5 style=\"margin-top: 5px;\">IT'S FREE!</h5>
                                    </div>   
                                    <div class=\"pull-right\" style=\"text-align: right;\">
                                        <a href=\"";
        // line 135
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_resetting_request");
        echo "\">Forgot Password?</a>
                                        <button type=\"submit\" class=\"btn btn-primary\" style=\"display: block;width: 100%;margin-top: 10px;\">Login</button>
                                    </div>
                                    ";
        // line 143
        echo "                                </div>
                            </div>
                        </form>

                    </div>
                    <div class=\"form-group row\">
                        <label class=\"col-sm-10\"></label>
                        <div class=\"col-sm-2\">
                            ";
        // line 152
        echo "                        </div>
                    </div>



                </div>
            </div><!-- end col-->


        </div>


    </div> <!-- container -->



    <!-- Footer -->
    <footer class=\"footer text-right\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-xs-12\">
                    2017 © ProjectPro
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src=\"";
        // line 185
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 186
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/tether.min.js"), "html", null, true);
        echo "\"></script><!-- Tether for Bootstrap -->
    <script src=\"";
        // line 187
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 188
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/waves.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 189
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.nicescroll.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 190
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/switchery/switchery.min.js"), "html", null, true);
        echo "\"></script>

    <!--Morris Chart-->
    <script src=\"";
        // line 193
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/morris/morris.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 194
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/raphael/raphael-min.js"), "html", null, true);
        echo "\"></script>

    <!-- Counter Up  -->
    <script src=\"";
        // line 197
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/waypoints/lib/jquery.waypoints.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 198
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/plugins/counterup/jquery.counterup.min.js"), "html", null, true);
        echo "\"></script>

    <!-- App js -->
    <script src=\"";
        // line 201
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.core.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 202
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uplon/assets/js/jquery.app.js"), "html", null, true);
        echo "\"></script>


";
        // line 205
        $this->displayBlock('javascripts', $context, $blocks);
        // line 206
        echo "</body>
</html>





";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 9
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

    // line 10
    public function block_stylesheets($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 205
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
        return "@FOSUser/Security/login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  381 => 205,  364 => 10,  346 => 9,  329 => 206,  327 => 205,  321 => 202,  317 => 201,  311 => 198,  307 => 197,  301 => 194,  297 => 193,  291 => 190,  287 => 189,  283 => 188,  279 => 187,  275 => 186,  271 => 185,  236 => 152,  226 => 143,  220 => 135,  213 => 131,  197 => 118,  190 => 113,  184 => 111,  182 => 110,  177 => 109,  174 => 108,  169 => 105,  166 => 104,  164 => 103,  162 => 102,  160 => 101,  158 => 100,  137 => 81,  101 => 30,  85 => 17,  81 => 16,  77 => 15,  73 => 14,  69 => 13,  65 => 12,  60 => 11,  58 => 10,  54 => 9,  44 => 1,);
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
        <title>{% block title %}Project Pro{% endblock %}</title>
    {% block stylesheets %}{% endblock %}
    <link rel=\"icon\" type=\"image/x-icon\" href=\"{{ asset('images/pprologo.png') }}\"/>
    <link rel=\"stylesheet\" href=\"{{ asset('uplon/assets/plugins/morris/morris.css') }}\">
    <link href=\"{{ asset('uplon/assets/plugins/switchery/switchery.min.css') }}\" rel=\"stylesheet\"/>
    <link href=\"{{ asset('uplon/assets/css/style.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"{{ asset('uplon/assets/public/stylesheets/style.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"{{ asset('uplon/assets/css/overrides.css') }}\" rel=\"stylesheet\" type=\"text/css\"/>
    <script src=\"{{ asset('uplon/assets/js/modernizr.min.js') }}\"></script>
</head>
<body>


    <!-- Navigation Bar-->
    <header id=\"topnav\">
        <div class=\"topbar-main\">
            <div class=\"container\">

                <!-- LOGO -->
                <div class=\"topbar-left\">
                    <a href=\"#\" class=\"logo\">
                        <img src=\"{{ asset('images/logo-web-banner.png') }}\"/>
                    </a>
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


                    </ul>

                </div> <!-- end menu-extras -->
                <div class=\"clearfix\"></div>

            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->


        {#<div class=\"navbar-custom\">
            <div class=\"container\">
                <div id=\"navigation\">
                    <!-- Navigation Menu-->
                    <ul class=\"navigation-menu\">
                        <li>
                            <a href=\"{{ path('fos_user_security_login') }}\"><i class=\"zmdi zmdi-key\"></i>
                                <span> Login </span> </a>
                        </li>
                        <li>
                            <a href=\"{{ path('fos_user_registration_register') }}\"><i class=\"zmdi zmdi-account\"></i> <span> Register </span>
                            </a>
                        </li>
                    </ul>
                    <!-- End navigation menu  -->
                </div>
            </div>
        </div>#}
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
                </div>
            </div>
            <div class=\"row m-t-20\">
                <div class=\"col-xs-12 col-lg-6 col-lg-offset-3\">
                    <div class=\"card-box\">

                        <h2 class=\"m-t-0 m-b-20\">Login</h2>
                        {% if error %}
                            {#<div class=\"alert alert-danger\" role=\"alert\">#}
                            {#<strong>Oh snap!</strong> Change a few things up and try submitting again.#}
                            {#</div>#}
                            <div class=\"alert alert-danger\" role=\"alert\">
                                <strong>{{ error.messageKey|trans(error.messageData, 'security') }}</strong>
                            </div>
                            {#<div>{{ error.messageKey|trans(error.messageData, 'security') }}</div>#}
                        {% endif %}
                        <form action=\"{{ path(\"fos_user_security_check\") }}\" method=\"post\">
                            {% if csrf_token %}
                                <input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token }}\" />
                            {% endif %}
                            <div class=\"form-group row\">
                                <label for=\"email\" class=\"col-sm-2 form-control-label\">Email</label>
                                <div class=\"col-sm-10\">
                                    <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Email\"
                                           name=\"_username\"
                                           value=\"{{ last_username }}\" required>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label for=\"inputPassword3\" class=\"col-sm-2 form-control-label\">Password</label>
                                <div class=\"col-sm-10\">
                                    <input type=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\"
                                           name=\"_password\" required>
                                </div>
                            </div>
                            <div class=\"form-group row\">
                                <label class=\"col-sm-2\"></label>
                                <div class=\"col-sm-10\">
                                    <div class=\"pull-left\"><span>Don't have an account? <a href=\"{{ path('fos_user_registration_register') }}\">Sign up!</a></span>       
                                        <h5 style=\"margin-top: 5px;\">IT'S FREE!</h5>
                                    </div>   
                                    <div class=\"pull-right\" style=\"text-align: right;\">
                                        <a href=\"{{ path('fos_user_resetting_request') }}\">Forgot Password?</a>
                                        <button type=\"submit\" class=\"btn btn-primary\" style=\"display: block;width: 100%;margin-top: 10px;\">Login</button>
                                    </div>
                                    {#<div class=\"checkbox checkbox-primary\">
                                        <input id=\"rememberMe\" type=\"checkbox\" name=\"rememberMe\">
                                        <label for=\"rememberMe\">
                                            Keep me logged in for the day
                                        </label>#}
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class=\"form-group row\">
                        <label class=\"col-sm-10\"></label>
                        <div class=\"col-sm-2\">
                            {#<button type=\"submit\" class=\"btn btn-primary pull-right\">Login</button>#}
                        </div>
                    </div>



                </div>
            </div><!-- end col-->


        </div>


    </div> <!-- container -->



    <!-- Footer -->
    <footer class=\"footer text-right\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-xs-12\">
                    2017 © ProjectPro
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src=\"{{ asset('uplon/assets/js/jquery.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/tether.min.js') }}\"></script><!-- Tether for Bootstrap -->
    <script src=\"{{ asset('uplon/assets/js/bootstrap.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/waves.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/jquery.nicescroll.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/switchery/switchery.min.js') }}\"></script>

    <!--Morris Chart-->
    <script src=\"{{ asset('uplon/assets/plugins/morris/morris.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/raphael/raphael-min.js') }}\"></script>

    <!-- Counter Up  -->
    <script src=\"{{ asset('uplon/assets/plugins/waypoints/lib/jquery.waypoints.min.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/plugins/counterup/jquery.counterup.min.js') }}\"></script>

    <!-- App js -->
    <script src=\"{{ asset('uplon/assets/js/jquery.core.js') }}\"></script>
    <script src=\"{{ asset('uplon/assets/js/jquery.app.js') }}\"></script>


{% block javascripts %}{% endblock %}
</body>
</html>





", "@FOSUser/Security/login.html.twig", "/Applications/MAMP/htdocs/projectpro-web/app/Resources/FOSUserBundle/views/Security/login.html.twig");
    }
}
