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

/* dashboard/accountant.html.twig */
class __TwigTemplate_82c0ce4685b579102efb3db82db5dc454655766c861ae2c6e86253182fb5aa0e extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'pageheader' => [$this, 'block_pageheader'],
            'body' => [$this, 'block_body'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'javascripts' => [$this, 'block_javascripts'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard/accountant.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "dashboard/accountant.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "dashboard/accountant.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 2
    public function block_pageheader($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageheader"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "pageheader"));

        echo "Accountant Dashboard";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "<style>
</style>
<div class=\"setup-wizard-container hide page-help resizable\">
    <div class=\"setup-wizard-header\">
        <h4>HELP</h4>
        <div class=\"dialog-close\" onclick=\"closeHelp()\">x</div>
    </div>
    <div class=\"setup-wizard-content\">
        <h5 style=\"text-align: center;\">ACCOUNTANT FUNCTIONS</h5>
        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>STANDARD OPERATING PROCEDURE</u>
                    </strong>
                </span>
            </span>
        </p>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">Approvers approve all submitted expenses on&nbsp; a designated weekday. Once a month, Accountants reconcile
                    approved purchases with credit card statements, then export reconciled purchases for import into the
                    accounting software.</span>
            </span>
        </p>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>SEND REMINDERS TO APPROVERS</u>
                    </strong>
                </span>
            </span>
        </p>

        <ul>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">To remind all Approvers to approve submitted purchases, click the reminders button (upper right)</span>
                </span>

                <ul style=\"list-style-type:circle\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Send Reminders (Approvers) - Clicking this will immediately send an email reminder to all approvers.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Schedule Reminders (Approvers) - Select a day or days to send an email reminder to all approvers.
                                Notifications will be sent at 7am CST on selected days every week. To stop reminders, uncheck
                                all days.</span>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>RECONCILE PURCHASES WITH CREDIT CARD STATEMENT</u>
                    </strong>
                </span>
            </span>
        </p>

        <ol>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Export your credit card statement transactions in excel format from your institution&rsquo;s website.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click the
                        <strong>Reconcile to CC Statement</strong> button</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Download the CC Statement template (an excel spreadsheet into which you will paste transactions from
                        the excel file you retrieved in step 1: Dates, Descriptions, Account numbers, &amp; Amounts). The
                        completed template will be imported back into ProjectPro. Using the template ensures that data is
                        placed appropriately and the reconcile process will work correctly. Importing any other file will
                        result in an error.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Open the template and paste data into the correct columns.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Save the completed template to a location on your hard drive that you can find easily in the next step.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Choose File</strong> and locate the template that you prepared in step 4. </span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Upload</strong>.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Select the purchases stored on ProjectPro to be reconciled with the data you imported in step 7.</span>
                </span>
                <ol style=\"list-style-type:lower-alpha\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Select all payment types that are represented on the imported transaction statement.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Select desired purchase status(s). If you are using the recommended operating procedure and having
                                an approver approve each purchase, select
                                <strong>Approved</strong>. If you are skipping the approval process, select
                                <strong>Not Approved</strong>. NOTE: You may select both if needed.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Click
                                <strong>Continue</strong>. </span>
                        </span>
                    </li>
                </ol>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Review Reconciliation</span>
                </span>
                <ol style=\"list-style-type:lower-alpha\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">ProjectPro will automatically match purchases that fall within the filters set in step 8 to the
                                uploaded credit card transactions if the date and amount match exactly. You can view those
                                matches by clicking the blue link in the grey box. Here you can also un-match purchases from
                                transactions by checking boxes and clicking
                                <strong>Unmatch</strong>. Click
                                <strong>Back</strong> when you are done.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">You can manually match remaining purchases to remaining credit card transactions by checking
                                their respective boxes and clicking
                                <strong>Match</strong>.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Before you leave this screen it is recommended that you delete any purchases and transactions
                                that will never be matched. All purchases and transactions that remain when you leave this
                                screen will be available for reconciliation until they are matched or deleted. Do this by
                                checking the boxes of desired purchases &amp; transactions.
                                <strong>Click Delete</strong>.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">When you are done, click
                                <strong>Continue</strong>.</span>
                        </span>
                    </li>
                </ol>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Export Reconciled Purchases</span>
                </span>
                <ol style=\"list-style-type:lower-alpha\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">All matched purchases will be previewed on the next screen. </span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">To export them, click
                                <strong>Export</strong> &amp; select the desired file format. </span>
                        </span>
                    </li>
                </ol>
            </li>
        </ol>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>EXPORT PURCHASES WITHOUT RECONCILING</u>
                    </strong> - If you choose not to reconcile to a credit card statement or you skipped exporting during the reconcile
                    process, you will want to export data for importing into your accounting software.</span>
            </span>
        </p>

        <ol>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Export Without Reconciling</strong>
                    </span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Select criteria for purchases you want to export and your preferred file format.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Export</strong>.</span>
                </span>
            </li>
        </ol>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>SELECT PURCHASES TO VIEW</u>
                    </strong>
                </span>
            </span>
        </p>

        <ul>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Filter purchases by Approval status, Reconciliation Status, Payment Types, and Approvers by clicking
                        the appropriate drop downs and selecting your preferences.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Search for purchases in a particular job by typing the job name in the search box.</span>
                </span>
            </li>
        </ul>

    </div>
    <div class=\"setup-wizard-footer\">
        <button class=\"btn btn-secondary\" onclick=\"closeHelp();\">Close</button>
    </div>
</div>
<div data-ng-controller=\"AccountantDashboardController\">
    <input type=\"hidden\" name=\"companyId\" id=\"companyId\" value=\"";
        // line 263
        echo twig_escape_filter($this->env, (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 263, $this->source); })()), "html", null, true);
        echo "\" /> 
    ";
        // line 264
        if ((isset($context["employeeId"]) || array_key_exists("employeeId", $context))) {
            // line 265
            echo "    <input type=\"hidden\" name=\"employeeId\" id=\"employeeId\" value=\"";
            echo twig_escape_filter($this->env, (isset($context["employeeId"]) || array_key_exists("employeeId", $context) ? $context["employeeId"] : (function () { throw new RuntimeError('Variable "employeeId" does not exist.', 265, $this->source); })()), "html", null, true);
            echo "\" /> 
    ";
        }
        // line 266
        echo "    
    <div class=\"row\">
        <div class=\"col-xs-12 form-inline\">
            <div class=\"\" style=\"margin-bottom: 0px;\">
                <button class=\"btn btn-secondary\" style=\"margin-right: 10px;\" data-ng-click=\"adhocExport()\">
                    <i class=\"fa fa-fw fa-download\"></i> Export without Reconciling
                </button>
                <button class=\"btn btn-primary\" style=\"margin-right: 10px;\" data-ng-click=\"initImportCreditStatement()\">
                    <i class=\"fa fa-fw fa-upload\"></i> Reconcile to CC Statement
                </button>
                <span data-ng-click=\"isFilterDates = true\">
                    <i class=\"fa fa-2x fa-calendar fa-fw\" style=\"top: 5px; position: relative; margin-right: 10px;\"></i>
                </span>
                <span data-ng-show=\"isFilterDates\">
                    <input class=\"form-control dpicker\" placeholder=\"Input Start Date\" data-ng-model=\"filterDateStart\" style=\"width: 180px;\"
                    />
                    <span style=\"margin: 0 3px;\">TO</span>
                    <input class=\"form-control dpicker\" placeholder=\"Input End Date\" data-ng-model=\"filterDateEnd\" style=\"width: 180px;\" />

                    <a href=\"javascript:void(0);\" data-ng-click=\"isFilterDates = false\" style=\"margin-left: 10px;\">REMOVE</a>
                </span>
                <div class=\"clearfix\"></div>
            </div>
        </div>
    </div>
    ";
        // line 332
        echo "
    <div class=\"row\">
        <div class=\"col-xs-12 form-inline filter-section\">
            <div class=\"filter-section-bar\">
                <div class=\"form-group\">
                    <input type=\"text\" placeholder=\"Search Job Name\" class=\"form-control\" data-ng-model=\"projectFilter\" />
                    <i class=\"fa fa-search\" style=\"left: -26px;position: relative;color: #ccc;\"></i>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"statusFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL</option>
                        <option value=\"STATUS_NOT_APPROVED\">NOT APPROVED</option>
                        <option value=\"STATUS_APPROVED\">APPROVED</option>
                        <option value=\"STATUS_DECLINED\">DECLINED</option>
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"reconciledFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL</option>
                        <option value=\"1\">RECONCILED</option>
                        <option value=\"0\">NOT RECONCILED</option>
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control paymenttypefilter\" title=\"All Payment Types\" multiple data-ng-model=\"paymentTypesFilter\" data-ng-options=\"p.id as p.name for p in listPaymentTypes\">
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"approverFilter\" data-ng-options=\"(a.employee.user.first_name + ' ' + a.employee.user.last_name + ' (' + a.unapprovedCount + ')') for a in approvers\">
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"exportedFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL </option>
                        <option value=\"1\">EXPORTED</option>
                        <option value=\"0\">NOT EXPORTED</option>
                    </select>
                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-xs-12\">
                    <div class=\"card-box\">
                        <div class=\"p-20 purchase-table\">
                            <table class=\"table hover-grey\">
                                <thead class=\"thead-default\">
                                    <tr>
                                        <th data-ng-click=\"sortColumn('project.name')\" style=\"width: 20% !important;\">Job
                                            <i data-ng-show=\"sortBy == 'project.name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('date_of_purchase')\" style=\"width: 10% !important;\">Purchase
                                            <br>Date
                                            <i data-ng-show=\"sortBy == 'date_of_purchase'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('payment_type.name')\" style=\"width:10% !important;\">Payment
                                            <br>Type
                                            <i data-ng-show=\"sortBy == 'payment_type.name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('total_amount')\" style=\"width: 10%!important; text-align: center;\">Amount
                                            <br/>
                                            <b>{[ getTotalAmountPurchases() | currency ]}</b>
                                            <i data-ng-show=\"sortBy == 'total_amount'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('purchaser.user.first_name')\" style=\"width: 12% !important;\">Submitted By
                                            <i data-ng-show=\"sortBy == 'purchaser.user.first_name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('approver.user.first_name')\" style=\"width: 10% !important;\">Approver
                                            <i data-ng-show=\"sortBy == 'approver.user.first_name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumnApproved('date_approved')\">Date
                                            <br>Approved/
                                            <span style=\"color: #d17a22;\">Declined </span>
                                            <i data-ng-show=\"sortBy == 'date_approved'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\">
                                        </th>
                                        <th data-ng-click=\"sortColumn('date_exported')\">Date Exported
                                            <i data-ng-show=\"sortBy == 'date_exported'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat=\"p in filteredPurchases = (purchases | filter:search) | orderBy:sortBy:reverse:comparer\">
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.project.name ]}\">
                                            {[ p.project.name ]}
                                        </td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.date_of_purchase | date:'MM/dd/yy' ]}\">{[ p.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.payment_type.name ]}\">{[ p.payment_type.name ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" style=\"text-align: center;\" title=\"{[ p.total_amount | currency ]}\">{[ p.total_amount | currency ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.purchaser.user.first_name ]} {[ p.purchaser.user.last_name ]}\">{[ p.purchaser.user.first_name ]} {[ p.purchaser.user.last_name ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\">
                                            <span data-ng-if=\"p.approver && !p.decliner\" title=\"{[ p.approver.user.first_name ]} {[ p.approver.user.last_name ]}\">{[ p.approver.user.first_name ]} {[ p.approver.user.last_name ]}</span>
                                            <span style=\"color: #d17a22\" data-ng-if=\"p.decliner\" title=\"{[ p.decliner.user.first_name ]} {[ p.decliner.user.last_name ]}\">{[ p.decliner.user.first_name ]} {[ p.decliner.user.last_name ]}</span>
                                        </td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\">
                                            <span title=\"{[ p.date_approved | date:'MM/dd/yy' ]}\" data-ng-if=\"!p.date_declined\">{[ p.date_approved | date:'MM/dd/yy' ]}</span>
                                            <span style=\"color: #d17a22\" title=\"{[ p.date_declined | date:'MM/dd/yy' ]}\" data-ng-if=\"p.date_declined\">{[ p.date_declined | date:'MM/dd/yy' ]}</span>
                                        </td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.date_exported | date:'MM/dd/yy' ]}\">{[ p.date_exported | date:'MM/dd/yy' ]}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"uploadStatementModal\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Import Credit Card Data</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <form id=\"uploadCreditCardStatmentForm\" action=\"{[ ccStatementUrl ]}\" method=\"POST\" enctype=\"multipart/form-data\">
                            <div class=\"modal-body\">
                                <div class=\"alert alert-info\" role=\"alert\">
                                    <strong>STEP 1 Download the Credit Card Statement Template</strong>
                                </div>
                                <a href=\"/api/download/ccStatementTemplate\">
                                    <button type=\"button\" class=\"btn btn-success\">
                                        <i class=\"fa fa-fw fa-download\"></i> Download</button>
                                </a>

                                <hr>

                                <div class=\"alert alert-info\" role=\"alert\">
                                    <strong>STEP 2 Upload from Credit Card Statement File</strong>
                                </div>
                                <fieldset class=\"form-group\">
                                    <label for=\"exampleInputEmail1\">Credit Card Statement File:</label>
                                    <input type=\"file\" accept=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel\" id=\"ccFile\"
                                        name=\"ccStatementFile\" required=\"required\" maxlength=\"50\" class=\"form-control\">
                                </fieldset>
                                <fieldset class=\"form-group\">
                                    <input id=\"importCompanyId\" type=\"hidden\" name=\"companyId\" value=\"2\">
                                </fieldset>




                            </div>

                            <div class=\"modal-footer\">
                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" data-ng-click=\"SkipUploadCreditCard()\">Skip</button>
                                <button type=\"submit\" class=\"btn btn-primary\" data-ng-click=\"showLoader()\">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"prepareReconcileModal\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Filter Purchases to Reconcile</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Tick the Payment Types and Purchase Statuses to Reconcile</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <h4>Payment Type</h4>
                                    <div class=\"checkbox checkbox-primary\">
                                                <input id=\"ptAllPaymentTypes\" name=\"ptAllPaymentTypes\" data-ng-change=\"ptCheckAll()\" data-ng-init=\"ptAllChecked = true\" data-ng-model=\"ptAllChecked\"
                                                    type=\"checkbox\">
                                                <label for=\"ptAllPaymentTypes\">
                                                    All Payment Types
                                                </label>
                                    </div>
                                    <div class=\"container\" style=\"overflow-y: scroll; height:200px;\">
                                        <div class=\"row\">                                            
                                            <div class=\"col-md-12\" data-ng-repeat=\"pt in reconcilePaymentTypes\">
                                                <div class=\"checkbox checkbox-primary\">
                                                    <input id=\"pt{[pt.name]}\" name=\"pt{[pt.name]}\" data-ng-init=\"pt.checked = true\" data-ng-model=\"pt.checked\" type=\"checkbox\">
                                                    <label for=\"pt{[pt.name]}\">
                                                        {[pt.name]}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <h4>Status</h4>
                                    <div class=\"checkbox checkbox-primary\" data-ng-repeat=\"pt in listStatuses\">
                                        <input id=\"pt{[pt.name]}\" name=\"pt{[pt.name]}\" data-ng-model=\"pt.checked\" type=\"checkbox\">
                                        <label for=\"pt{[pt.name]}\">
                                            {[pt.name]}
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"reconcile()\" data-dismiss=\"modal\">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"reviewModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 95%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Review Reconciliation</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>
                                    <a href=\"javascript:void(0);\" onclick=\"\$('#reviewModal').modal('hide');\" data-ng-click=\"initReconciledModal()\">{[review.reconciled.length]} items</a> have been matched. The purchases & transactions
                                    shown below could not be matched. To manually reconcile a transaction to a purchase,
                                    place a check in both boxes and click MATCH. Click a purchase to view receipt. TIP: Unmatched
                                    items will be shown the next time you reconcile unless you DELETE them.</strong>
                            </div>
                            <div class=\"m-b-10\">
                                <button class=\"btn btn-success\" data-ng-disabled=\"isDisableMatch\" data-ng-click=\"matchUnreconciled()\">Match</button>
                                <button class=\"btn btn-danger\" data-ng-disabled=\"isDisableDelete\" data-ng-click=\"deleteItems()\">Delete</button>
                            </div>
                            <div style=\"text-align: center\">
                                <h4 data-ng-show=\"!review.unreconciled.purchases.length && !review.unreconciled.importedTransactions.length\">All possible matches have been made.</h4>
                            </div>
                            <div class=\"row\" data-ng-show=\"review.unreconciled.purchases.length || review.unreconciled.importedTransactions.length\">

                                <div class=\"col-md-8\" style=\"height: 540px;overflow: auto;\">
                                    <h4>Statement Transactions</h4>
                                    <table class=\"table purchase-table\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <!-- reviewheader -->
                                                <th style=\"width: 60px;\">
                                                    <input type=\"checkbox\" data-ng-model=\"transactionCheckAll\" data-ng-change=\"checkAll(transactionCheckAll, review.unreconciled.importedTransactions)\"
                                                    />
                                                </th>
                                                <th style=\"width: 100px;\" data-ng-click=\"sortColumnReconcileIT('account_number')\">Account</th>
                                                <th style=\"width: 115px;\" data-ng-click=\"sortColumnReconcileIT('date')\">Post Date</th>
                                                <th style=\"width: 100px;\" data-ng-click=\"sortColumnReconcileIT('amount')\">Amount</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"it in review.unreconciled.importedTransactions | orderBy:reconcileOptions.importedTransactions.sortBy:reconcileOptions.importedTransactions.reverse\">
                                                <td>
                                                    <input type=\"checkbox\" data-ng-model=\"it.checked\" data-ng-change=\"selectOnly(it, review.unreconciled.importedTransactions)\"
                                                    />
                                                </td>
                                                <td>...{[ it.account_number | limitTo: -6 ]}</td>
                                                <td>{[ it.date | date:'MM/dd/yy' ]}</td>
                                                <td>{[ it.amount | currency ]}</td>
                                                <td>{[ it.description ]}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class=\"col-md-4\" style=\"height: 540px;overflow: auto;\">
                                    <h4>Purchases</h4>
                                    <table class=\"table purchase-table hover-grey\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th>
                                                    <input type=\"checkbox\" data-ng-model=\"purchaseCheckAll\" data-ng-change=\"checkAll(purchaseCheckAll, review.unreconciled.purchases)\"
                                                    />
                                                </th>
                                                <th data-ng-click=\"sortColumnReconcileP('payment_type.name')\">Payment Type</th>
                                                <th data-ng-click=\"sortColumnReconcileP('date_of_purchase')\">Purchase Date</th>
                                                <th data-ng-click=\"sortColumnReconcileP('total_amount')\">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"p in review.unreconciled.purchases | orderBy:reconcileOptions.purchases.sortBy:reconcileOptions.purchases.reverse\">
                                                <td>
                                                    <input type=\"checkbox\" data-ng-model=\"p.checked\" data-ng-change=\"selectOnly(p, review.unreconciled.purchases)\" />
                                                </td>
                                                <td data-ng-click=\"loadPurchaseStatic(p)\">{[ p.payment_type.name ]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(p)\">{[ p.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                ";
        // line 625
        echo "                                                <td data-ng-click=\"loadPurchaseStatic(p)\">{[ p.total_amount | currency ]}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"submit\" class=\"btn btn-primary\" data-ng-click=\"finishReview()\">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"reconciledModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 80%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Reconciled Transactions/Purchases</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>The Transactions and Purchases below have been matched. To unmatch them, check the box and
                                    select UNMATCH.
                                </strong>
                            </div>
                            <div class=\"m-b-10\">
                                <button class=\"btn btn-danger\" data-ng-click=\"unmatchReconciled()\">Unmatch</button>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-12\">
                                    <h4>Reconciled Transactions</h4>
                                    <table class=\"table purchase-table hover-grey\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th colspan=\"5\" style=\"
                                                text-align: center;
                                                font-size: 20px;
                                                background: #3F51B5;
                                                color: #FFF;
                                                \">Statement Transactions</th>
                                                <th colspan=\"3\" style=\"
                                                text-align: center;
                                                font-size: 20px;
                                                background: #3F51B5;
                                                color: #FFF;
                                                border-left: solid 1px #FFF;
                                                \">Purchases</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>Account</th>
                                                <th>Purchase Date (Statement)</th>
                                                <th>Amount (Statement)</th>
                                                <th>Description</th>
                                                <th style=\"border-left: solid 1px #000;\">Payment Type</th>
                                                <th>Purchase Date (Purchase)</th>
                                                <th>Amount (Purchase)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"r in review.reconciled\">
                                                <td>
                                                    <input type=\"checkbox\" data-ng-model=\"r.checked\" data-ng-change=\"selectOnlyReconciled(r, review.reconciled)\" />
                                                </td>
                                                <td>X-{[ r.importedTransaction.account_number | limitTo: -5 ]}</td>
                                                <td>{[ r.importedTransaction.date | date:'MM/dd/yy' ]}</td>
                                                <td>{[ r.importedTransaction.amount ]}</td>
                                                <td>{[ r.importedTransaction.description ]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(r.purchase)\" style=\"border-left: solid 1px #000;\">{[ r.purchase.payment_type.name]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(r.purchase)\">{[ r.purchase.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(r.purchase)\">{[ r.purchase.total_amount ]}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" onclick=\"\$('#reviewModal').modal('show');\">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"exportPreviewModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 80%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Export Reconciled Purchases</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Here are the items available for export</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-12\" style=\"height: 500px; overflow: auto;\">
                                    <h4>Reconciled Transactions</h4>
                                    <table class=\"table purchase-table\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th>Job</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Payment Type</th>
                                                <th>Class (opt)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"e in exportReviews | orderBy:['matched_imported_transaction.date','purchase.payment_type.name']\">
                                                <td>{[ e.purchase.project.name ]} ({[ e.purchase.project.number ]})</td>
                                                <td>{[ e.cost.description ]} ({[ e.cost.expense_type ]})</td>
                                                <td>{[ e.purchase.matched_imported_transaction.description ]}</td>
                                                <td>{[ e.amount ]}</td>
                                                <td>{[ e.purchase.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                <td>{[ e.purchase.payment_type.name ]}</td>
                                                <td>
                                                    <select data-ng-change=\"associateClass(e.id, e.purchase_class.id)\" data-ng-init=\"e.purchase_class.id = (!e.purchase_class.id ? 0 : e.purchase_class.id)\" data-ng-model=\"e.purchase_class.id\" data-ng-options=\"c.item.id as c.item.name for c in classes\">
                                                        <option value=\"\" ng-show=\"false\"></option>
                                                    </select>
                                                </td>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                        <div class=\"modal-footer\">
                        ";
        // line 771
        if ((isset($context["isQbIntegrated"]) || array_key_exists("isQbIntegrated", $context) ? $context["isQbIntegrated"] : (function () { throw new RuntimeError('Variable "isQbIntegrated" does not exist.', 771, $this->source); })())) {
            echo "                          
                        <button class=\"btn btn-primary\" data-ng-click=\"importToQuickBooks()\">Import to QuickBooks</button>
                        ";
        }
        // line 774
        echo "                            <div class=\"btn-group\">
                                <button type=\"button\" class=\"btn btn-primary dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">Export
                                    <span class=\"caret\"></span>
                                </button>
                                <div class=\"dropdown-menu\">
                                    <a class=\"dropdown-item\" href=\"/api/company/";
        // line 779
        echo twig_escape_filter($this->env, (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 779, $this->source); })()), "html", null, true);
        echo "/export?type=excel\">Excel</a>
                                    <a class=\"dropdown-item\" href=\"/api/company/";
        // line 780
        echo twig_escape_filter($this->env, (isset($context["companyId"]) || array_key_exists("companyId", $context) ? $context["companyId"] : (function () { throw new RuntimeError('Variable "companyId" does not exist.', 780, $this->source); })()), "html", null, true);
        echo "/export?type=csv\">CSV</a>
                                </div>
                            </div>
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Skip</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"targetStaticPurchaseModal\">
                <div class=\"modal-dialog modal-lg\" role=\"document\" style=\"width: 70%;\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\" style=\"{[ targetPurchase.status == 'STATUS_DECLINED' ? 'background: #d17a22!important;' : '' ]}\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">
                                {[ targetPurchase.status == 'STATUS_NOT_APPROVED' ? 'UNAPPROVED PURCHASE' : '' ]} {[ targetPurchase.status == 'STATUS_APPROVED'
                                ? 'APPROVED PURCHASE' : '' ]} {[ targetPurchase.status == 'STATUS_DECLINED' ? 'DECLINED PURCHASE'
                                : '' ]}
                            </h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <div class=\"row\">
                                <div class=\"col-md-6 drift-pane\">
                                    <div class=\"row\">
                                        <div class=\"col-md-6\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Job</label>
                                                <span> {[ targetPurchase.project.name ]} ({[ targetPurchase.project.number ]})</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Submitted By: </label>
                                                <span> {[ targetPurchase.purchaser.user.first_name ]} {[ targetPurchase.purchaser.user.last_name
                                                    ]}
                                                </span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Date of Purchase</label>
                                                <span>{[ targetPurchase.date_of_purchase | date:'MM/dd/yyyy' ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\" data-ng-show=\"targetPurchase.vendor != null\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Vendor:</label>
                                                <span>{[ targetPurchase.vendor.name ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                             <fieldset class=\"form-group\">
                                                <label for=\"\">Payment Type</label>
                                                <span>{[ targetPurchase.payment_type.name ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                             <fieldset class=\"form-group\">
                                                <label for=\"\">Total Amount</label>
                                                <span>{[ targetPurchase.total_amount | currency ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                            <fieldsest class=\"form-group\" style=\"color: #d17a22;\" data-ng-if=\"targetPurchase.status == 'STATUS_DECLINED'\">
                                                <label for=\"\">Declined By {[targetPurchase.decliner.user.first_name]} {[targetPurchase.decliner.user.last_name]}
                                                    on {[targetPurchase.date_declined | date]}</label>
                                            </fieldsest>
                                        </div>
                                        <div class=\"col-md-12\">
                                             <fieldset class=\"form-group\" style=\"color: #d17a22;\" data-ng-if=\"targetPurchase.status == 'STATUS_DECLINED' && targetPurchase.comments.length\">
                                                <label for=\"\">Comments</label>
                                                <span>{[ targetPurchase.comments ]}</span>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                   
                                   
                                    
                                   
                                    <div style=\"text-align: right;margin-right: 20px;\">
                                        <small style=\"color: #d17a22;\">inclusive of sales tax ({[ (targetPurchase.is_override_sales_tax ? 0 : targetPurchase.sales_tax)
                                            | currency ]}) {[targetPurchase.is_override_sales_tax ? '*' : '']}</small>
                                    </div>
                                    <div class=\"p-20\" style=\"padding-top: 0!important;\" data-ng-if=\"targetPurchase.purchase_items.length\">
                                        <table class=\"table approver-table\">
                                            <tbody style=\"width: 100%;\">
                                                <tr class=\"thead-default\">
                                                    <td></td>
                                                    <td>Item</td>
                                                    <td>Amount
                                                        <small style=\"color: red;\">inclusive of sales tax ({[ (isSalesTaxOverride ? 0 : targetPurchase.sales_tax)
                                                            | currency ]}) {[isSalesTaxOverride ? '*' : '']}</small>
                                                    </td>
                                                </tr>
                                                <tr data-ng-repeat=\"pc in targetPurchase.purchase_items\" data-ng-init=\"getSalesTaxCalculated(pc)\">
                                                    <td></td>
                                                    <td data-ng-if=\"!pc.cost.hidden\">{[ pc.cost.code_number ]} {[ pc.cost.description ]} {[ pc.cost.expense_type
                                                        ]}
                                                    </td>
                                                    <td data-ng-if=\"pc.cost.hidden\">{[ pc.cost.description ]}</td>
                                                    <td style=\"text-align: right; \">{[ pc.postAmount | currency ]}</td>
                                                    <td class=\"memo\">
                                                        <div style=\"white-space: normal;\">{[ pc.memo ]}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style=\"text-align: right; font-weight: bold;\">TOTAL:</td>
                                                    <td style=\"text-align: right; font-weight: bold;\">{[ getTotalPostAmount(targetPurchase) | currency : \"\$\" : 2 ]}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class=\"col-md-6 text-center\">
                                    <a class=\"text-center\" data-ng-href=\"{[ targetPurchase.image ]}\" style=\"text-align: center;\" data-toggle=\"lightbox\">
                                        <img data-ng-src=\"{[ targetPurchase.image ]}\" data-zoom=\"{[ targetPurchase.image ]}\" style=\"margin: 0 auto; max-height: calc(88vh - 200px);\"
                                            class=\"img-fluid receipt-image\">
                                        <p style=\"color: #d17a22;\">(Roll over image to zoom)</p>
                                    </a>
                                    ";
        // line 906
        echo " ";
        // line 907
        echo " ";
        // line 908
        echo " ";
        // line 910
        echo "                                </div>
                            </div>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"button\" data-ng-if=\"targetPurchase.status == 'STATUS_NOT_APPROVED'\" class=\"btn btn-secondary tertiary\" data-ng-click=\"declinePurchase()\">Decline</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"declineCommentPurchaseModal\">
                <div class=\"modal-dialog modal-md\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Confirm Declined Purchase</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <div class=\"row\">
                                <div class=\"col-md-12\">
                                    <textarea data-ng-model=\"comment\" class=\"form-control\" placeholder=\"Type Comment Here (Optional)\" style=\"font-size: 18px;\"
                                        rows=\"10\"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
                            <button type=\"button\" class=\"btn btn-secondary tertiary\" data-ng-click=\"confirmDecline()\">Confirm Decline</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"exportCustomModal\">
                <div class=\"modal-dialog modal-lg\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Filter Purchases to Export</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\" style=\"height: calc(75vh - 200px);overflow-y: auto;\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Tick the radio buttons to filter exports</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-3\">
                                    <h4>Payment Types</h4>
                                    <div>
                                        <select class=\"form-control paymenttypefilter\" title=\"All Payment Types\" multiple data-ng-model=\"paymentTypesFilterExport\"
                                            data-ng-options=\"p.id as p.name for p in listPaymentTypes\">
                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <h4>Reconciled?</h4>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"reconcile\" data-ng-model=\"customExport.reconciled\" id=\"radioR1\" value=\"yes\" checked=\"\">
                                        <label for=\"radioR1\">
                                            Yes
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"reconcile\" data-ng-model=\"customExport.reconciled\" id=\"radioR2\" value=\"no\" checked=\"\">
                                        <label for=\"radioR2\">
                                            No
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"reconcile\" data-ng-model=\"customExport.reconciled\" id=\"radioR3\" value=\"all\" checked=\"\">
                                        <label for=\"radioR3\">
                                            All
                                        </label>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <h4>Approved?</h4>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"approved\" data-ng-model=\"customExport.approved\" id=\"radioA1\" value=\"yes\" checked=\"\">
                                        <label for=\"radioA1\">
                                            Yes
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"approved\" data-ng-model=\"customExport.approved\" id=\"radioA2\" value=\"no\" checked=\"\">
                                        <label for=\"radioA2\">
                                            No
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"approved\" data-ng-model=\"customExport.approved\" id=\"radioA3\" value=\"all\" checked=\"\">
                                        <label for=\"radioA3\">
                                            All
                                        </label>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <h4>Type?</h4>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"type\" data-ng-model=\"customExport.type\" id=\"radioT1\" value=\"excel\" checked=\"\">
                                        <label for=\"radioT1\">
                                            Excel
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"type\" data-ng-model=\"customExport.type\" id=\"radioT2\" value=\"csv\" checked=\"\">
                                        <label for=\"radioT2\">
                                            CSV
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"adhocExportReview()\">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"exportAdhocPreviewModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 80%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">REVIEW PURCHASES FOR EXPORT</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Here are the items available for export</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-12\" style=\"height: 500px; overflow: auto;\">
                                    <h4>Review Transactions for Export</h4>
                                    <table class=\"table purchase-table\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th>Job</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Payment Type</th>
                                                <th>Class (opt)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"e in exportReviews | orderBy:['purchase.date_of_purchase','purchase.payment_type.name']\">
                                                <td>{[ e.purchase.project.name ]} ({[ e.purchase.project.number ]})</td>
                                                <td>{[ e.cost.code_number ]}</td>
                                                <td>{[ e.cost.description ]} ({[ e.cost.expense_type ]})</td>
                                                <td>{[ e.amount ]}</td>
                                                <td>{[ e.purchase.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                <td>{[ e.purchase.payment_type.name ]}</td>
                                                <td>
                                                    <select data-ng-change=\"associateClass(e.id, e.purchase_class.id)\" data-ng-model=\"e.purchase_class.id\" data-ng-options=\"c.item.id as c.item.name for c in classes\"></select>
                                                </td>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                            <div class=\"modal-footer\">
                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
                                ";
        // line 1088
        if ((isset($context["isQbIntegrated"]) || array_key_exists("isQbIntegrated", $context) ? $context["isQbIntegrated"] : (function () { throw new RuntimeError('Variable "isQbIntegrated" does not exist.', 1088, $this->source); })())) {
            // line 1089
            echo "                                <button class=\"btn btn-primary\" data-ng-click=\"importToQuickBooks()\">Import to QuickBooks</button>
                                ";
        }
        // line 1091
        echo "                                <a data-ng-href=\"/api/export/dashboard?type={[customExport.type]}&approved={[customExport.approved]}&reconciled={[customExport.reconciled]}&companyId={[customExport.companyId]}{[ paymentTypeExportQuery ]}\">
                                    <button type=\"button\" class=\"btn btn-primary\">Export</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"checkDuplciateTransactionsModal\">
                <div class=\"modal-dialog modal-lg\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Duplicate Transactions Detected</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <h3 style=\"text-align: center;\">
                                WARNING - Some or all of these transactions have been imported previously. Importing them again could result in a large number
                                of unreconciled transactions.
                            </h3>
                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\" data-ng-click=\"deleteDuplicateTransactions()\">Cancel</button>
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" data-ng-click=\"openPrepareReconcileModal()\">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1128
    public function block_stylesheets($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 1129
        echo "        <style>
            /*
        .purchase-table th[data-ng-click]:hover {
            background: #315da6;
            color: #FFF;
            cursor: pointer;
        }

        .purchase-table th:active {
            background: #000;
            color: #FFF;
        }
        */

            .purchase-table th[data-ng-click]:hover {
                cursor: pointer;
            }

            .purchase-table th[data-ng-click] i {
                display: inline;
            }

            .purchase-table th[data-ng-click]:hover i {
                display: inline !important;
            }

            .orange {
                color: #d17a22;
            }
        </style>
        <link rel=\"stylesheet\" href=\"";
        // line 1159
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/table.css"), "html", null, true);
        echo "\"> 
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1161
    public function block_javascripts($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 1162
        echo "        <script>
            \$(function () {
                \$('.dpicker').datepicker();
                new Drift(document.querySelector('.receipt-image'), {
                    paneContainer: document.querySelector('.drift-pane')
                });
            });
        </script>
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "dashboard/accountant.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1271 => 1162,  1262 => 1161,  1250 => 1159,  1218 => 1129,  1209 => 1128,  1163 => 1091,  1159 => 1089,  1157 => 1088,  977 => 910,  975 => 908,  973 => 907,  971 => 906,  844 => 780,  840 => 779,  833 => 774,  827 => 771,  679 => 625,  386 => 332,  359 => 266,  353 => 265,  351 => 264,  347 => 263,  86 => 4,  77 => 3,  59 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}
{% block pageheader %}Accountant Dashboard{% endblock %}
{% block body %}
<style>
</style>
<div class=\"setup-wizard-container hide page-help resizable\">
    <div class=\"setup-wizard-header\">
        <h4>HELP</h4>
        <div class=\"dialog-close\" onclick=\"closeHelp()\">x</div>
    </div>
    <div class=\"setup-wizard-content\">
        <h5 style=\"text-align: center;\">ACCOUNTANT FUNCTIONS</h5>
        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>STANDARD OPERATING PROCEDURE</u>
                    </strong>
                </span>
            </span>
        </p>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">Approvers approve all submitted expenses on&nbsp; a designated weekday. Once a month, Accountants reconcile
                    approved purchases with credit card statements, then export reconciled purchases for import into the
                    accounting software.</span>
            </span>
        </p>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>SEND REMINDERS TO APPROVERS</u>
                    </strong>
                </span>
            </span>
        </p>

        <ul>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">To remind all Approvers to approve submitted purchases, click the reminders button (upper right)</span>
                </span>

                <ul style=\"list-style-type:circle\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Send Reminders (Approvers) - Clicking this will immediately send an email reminder to all approvers.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Schedule Reminders (Approvers) - Select a day or days to send an email reminder to all approvers.
                                Notifications will be sent at 7am CST on selected days every week. To stop reminders, uncheck
                                all days.</span>
                        </span>
                    </li>
                </ul>
            </li>
        </ul>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>RECONCILE PURCHASES WITH CREDIT CARD STATEMENT</u>
                    </strong>
                </span>
            </span>
        </p>

        <ol>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Export your credit card statement transactions in excel format from your institution&rsquo;s website.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click the
                        <strong>Reconcile to CC Statement</strong> button</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Download the CC Statement template (an excel spreadsheet into which you will paste transactions from
                        the excel file you retrieved in step 1: Dates, Descriptions, Account numbers, &amp; Amounts). The
                        completed template will be imported back into ProjectPro. Using the template ensures that data is
                        placed appropriately and the reconcile process will work correctly. Importing any other file will
                        result in an error.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Open the template and paste data into the correct columns.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Save the completed template to a location on your hard drive that you can find easily in the next step.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Choose File</strong> and locate the template that you prepared in step 4. </span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Upload</strong>.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Select the purchases stored on ProjectPro to be reconciled with the data you imported in step 7.</span>
                </span>
                <ol style=\"list-style-type:lower-alpha\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Select all payment types that are represented on the imported transaction statement.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Select desired purchase status(s). If you are using the recommended operating procedure and having
                                an approver approve each purchase, select
                                <strong>Approved</strong>. If you are skipping the approval process, select
                                <strong>Not Approved</strong>. NOTE: You may select both if needed.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Click
                                <strong>Continue</strong>. </span>
                        </span>
                    </li>
                </ol>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Review Reconciliation</span>
                </span>
                <ol style=\"list-style-type:lower-alpha\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">ProjectPro will automatically match purchases that fall within the filters set in step 8 to the
                                uploaded credit card transactions if the date and amount match exactly. You can view those
                                matches by clicking the blue link in the grey box. Here you can also un-match purchases from
                                transactions by checking boxes and clicking
                                <strong>Unmatch</strong>. Click
                                <strong>Back</strong> when you are done.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">You can manually match remaining purchases to remaining credit card transactions by checking
                                their respective boxes and clicking
                                <strong>Match</strong>.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">Before you leave this screen it is recommended that you delete any purchases and transactions
                                that will never be matched. All purchases and transactions that remain when you leave this
                                screen will be available for reconciliation until they are matched or deleted. Do this by
                                checking the boxes of desired purchases &amp; transactions.
                                <strong>Click Delete</strong>.</span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">When you are done, click
                                <strong>Continue</strong>.</span>
                        </span>
                    </li>
                </ol>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Export Reconciled Purchases</span>
                </span>
                <ol style=\"list-style-type:lower-alpha\">
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">All matched purchases will be previewed on the next screen. </span>
                        </span>
                    </li>
                    <li>
                        <span style=\"font-size:11pt\">
                            <span style=\"font-family:Calibri,sans-serif\">To export them, click
                                <strong>Export</strong> &amp; select the desired file format. </span>
                        </span>
                    </li>
                </ol>
            </li>
        </ol>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>EXPORT PURCHASES WITHOUT RECONCILING</u>
                    </strong> - If you choose not to reconcile to a credit card statement or you skipped exporting during the reconcile
                    process, you will want to export data for importing into your accounting software.</span>
            </span>
        </p>

        <ol>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Export Without Reconciling</strong>
                    </span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Select criteria for purchases you want to export and your preferred file format.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Click
                        <strong>Export</strong>.</span>
                </span>
            </li>
        </ol>

        <p style=\"margin-left:0in; margin-right:0in\">
            <span style=\"font-size:11pt\">
                <span style=\"font-family:Calibri,sans-serif\">
                    <strong>
                        <u>SELECT PURCHASES TO VIEW</u>
                    </strong>
                </span>
            </span>
        </p>

        <ul>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Filter purchases by Approval status, Reconciliation Status, Payment Types, and Approvers by clicking
                        the appropriate drop downs and selecting your preferences.</span>
                </span>
            </li>
            <li>
                <span style=\"font-size:11pt\">
                    <span style=\"font-family:Calibri,sans-serif\">Search for purchases in a particular job by typing the job name in the search box.</span>
                </span>
            </li>
        </ul>

    </div>
    <div class=\"setup-wizard-footer\">
        <button class=\"btn btn-secondary\" onclick=\"closeHelp();\">Close</button>
    </div>
</div>
<div data-ng-controller=\"AccountantDashboardController\">
    <input type=\"hidden\" name=\"companyId\" id=\"companyId\" value=\"{{ companyId }}\" /> 
    {% if employeeId is defined %}
    <input type=\"hidden\" name=\"employeeId\" id=\"employeeId\" value=\"{{ employeeId }}\" /> 
    {% endif %}    
    <div class=\"row\">
        <div class=\"col-xs-12 form-inline\">
            <div class=\"\" style=\"margin-bottom: 0px;\">
                <button class=\"btn btn-secondary\" style=\"margin-right: 10px;\" data-ng-click=\"adhocExport()\">
                    <i class=\"fa fa-fw fa-download\"></i> Export without Reconciling
                </button>
                <button class=\"btn btn-primary\" style=\"margin-right: 10px;\" data-ng-click=\"initImportCreditStatement()\">
                    <i class=\"fa fa-fw fa-upload\"></i> Reconcile to CC Statement
                </button>
                <span data-ng-click=\"isFilterDates = true\">
                    <i class=\"fa fa-2x fa-calendar fa-fw\" style=\"top: 5px; position: relative; margin-right: 10px;\"></i>
                </span>
                <span data-ng-show=\"isFilterDates\">
                    <input class=\"form-control dpicker\" placeholder=\"Input Start Date\" data-ng-model=\"filterDateStart\" style=\"width: 180px;\"
                    />
                    <span style=\"margin: 0 3px;\">TO</span>
                    <input class=\"form-control dpicker\" placeholder=\"Input End Date\" data-ng-model=\"filterDateEnd\" style=\"width: 180px;\" />

                    <a href=\"javascript:void(0);\" data-ng-click=\"isFilterDates = false\" style=\"margin-left: 10px;\">REMOVE</a>
                </span>
                <div class=\"clearfix\"></div>
            </div>
        </div>
    </div>
    {#
    <div class=\"row\">
        <div class=\"col-xs-12 form-inline filter-section\">
            <div style=\"padding: 0px!important;\">
                <div class=\"form-group\">
                    <input type=\"text\" placeholder=\"Search Project Name\" class=\"form-control\" data-ng-model=\"projectFilter\" />
                    <i class=\"fa fa-search\" style=\"left: -26px;position: relative;color: #ccc;\"></i>
                </div>
                <div class=\"form-group p-20\">
                    <select class=\"form-control\" data-ng-model=\"statusFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL</option>
                        <option value=\"STATUS_NOT_APPROVED\">NOT APPROVED</option>
                        <option value=\"STATUS_APPROVED\">APPROVED</option>
                        <option value=\"STATUS_DECLINED\">DECLINED</option>
                    </select>
                </div>
                <div class=\"form-group p-20\">
                    <select class=\"form-control\" data-ng-model=\"reconciledFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL</option>
                        <option value=\"1\">RECONCILED</option>
                        <option value=\"0\">NOT RECONCILED</option>
                    </select>
                </div>
                <div class=\"form-group p-20\">
                    <select class=\"form-control paymenttypefilter\" title=\"All Payment Types\" multiple data-ng-model=\"paymentTypesFilter\" data-ng-options=\"p.id as p.name for p in listPaymentTypes\">
                    </select>
                </div>
                <div class=\"form-group p-20\">
                    <select class=\"form-control\" data-ng-model=\"approverFilter\" data-ng-options=\"(a.employee.user.first_name + ' ' + a.employee.user.last_name + ' (' + a.unapprovedCount + ')') for a in approvers\">
                    </select>
                </div>
                <div class=\"form-group p-20\">
                    <select class=\"form-control\" data-ng-model=\"exportedFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL </option>
                        <option value=\"1\">EXPORTED</option>
                        <option value=\"0\">NOT EXPORTED</option>
                    </select>
                </div>
            </div>
        </div>
    </div> #}

    <div class=\"row\">
        <div class=\"col-xs-12 form-inline filter-section\">
            <div class=\"filter-section-bar\">
                <div class=\"form-group\">
                    <input type=\"text\" placeholder=\"Search Job Name\" class=\"form-control\" data-ng-model=\"projectFilter\" />
                    <i class=\"fa fa-search\" style=\"left: -26px;position: relative;color: #ccc;\"></i>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"statusFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL</option>
                        <option value=\"STATUS_NOT_APPROVED\">NOT APPROVED</option>
                        <option value=\"STATUS_APPROVED\">APPROVED</option>
                        <option value=\"STATUS_DECLINED\">DECLINED</option>
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"reconciledFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL</option>
                        <option value=\"1\">RECONCILED</option>
                        <option value=\"0\">NOT RECONCILED</option>
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control paymenttypefilter\" title=\"All Payment Types\" multiple data-ng-model=\"paymentTypesFilter\" data-ng-options=\"p.id as p.name for p in listPaymentTypes\">
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"approverFilter\" data-ng-options=\"(a.employee.user.first_name + ' ' + a.employee.user.last_name + ' (' + a.unapprovedCount + ')') for a in approvers\">
                    </select>
                </div>
                <div class=\"form-group\">
                    <select class=\"form-control\" data-ng-model=\"exportedFilter\" data-ng-change=\"changeStatusFilter()\">
                        <option value=\"ALL\">ALL </option>
                        <option value=\"1\">EXPORTED</option>
                        <option value=\"0\">NOT EXPORTED</option>
                    </select>
                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-xs-12\">
                    <div class=\"card-box\">
                        <div class=\"p-20 purchase-table\">
                            <table class=\"table hover-grey\">
                                <thead class=\"thead-default\">
                                    <tr>
                                        <th data-ng-click=\"sortColumn('project.name')\" style=\"width: 20% !important;\">Job
                                            <i data-ng-show=\"sortBy == 'project.name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('date_of_purchase')\" style=\"width: 10% !important;\">Purchase
                                            <br>Date
                                            <i data-ng-show=\"sortBy == 'date_of_purchase'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('payment_type.name')\" style=\"width:10% !important;\">Payment
                                            <br>Type
                                            <i data-ng-show=\"sortBy == 'payment_type.name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('total_amount')\" style=\"width: 10%!important; text-align: center;\">Amount
                                            <br/>
                                            <b>{[ getTotalAmountPurchases() | currency ]}</b>
                                            <i data-ng-show=\"sortBy == 'total_amount'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('purchaser.user.first_name')\" style=\"width: 12% !important;\">Submitted By
                                            <i data-ng-show=\"sortBy == 'purchaser.user.first_name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumn('approver.user.first_name')\" style=\"width: 10% !important;\">Approver
                                            <i data-ng-show=\"sortBy == 'approver.user.first_name'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\"></i>
                                        </th>
                                        <th data-ng-click=\"sortColumnApproved('date_approved')\">Date
                                            <br>Approved/
                                            <span style=\"color: #d17a22;\">Declined </span>
                                            <i data-ng-show=\"sortBy == 'date_approved'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\">
                                        </th>
                                        <th data-ng-click=\"sortColumn('date_exported')\">Date Exported
                                            <i data-ng-show=\"sortBy == 'date_exported'\" class=\"fa fa-fw\" data-ng-class=\"{ 'fa-angle-down' : !reverse, 'fa-angle-up' : reverse}\">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat=\"p in filteredPurchases = (purchases | filter:search) | orderBy:sortBy:reverse:comparer\">
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.project.name ]}\">
                                            {[ p.project.name ]}
                                        </td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.date_of_purchase | date:'MM/dd/yy' ]}\">{[ p.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.payment_type.name ]}\">{[ p.payment_type.name ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" style=\"text-align: center;\" title=\"{[ p.total_amount | currency ]}\">{[ p.total_amount | currency ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.purchaser.user.first_name ]} {[ p.purchaser.user.last_name ]}\">{[ p.purchaser.user.first_name ]} {[ p.purchaser.user.last_name ]}</td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\">
                                            <span data-ng-if=\"p.approver && !p.decliner\" title=\"{[ p.approver.user.first_name ]} {[ p.approver.user.last_name ]}\">{[ p.approver.user.first_name ]} {[ p.approver.user.last_name ]}</span>
                                            <span style=\"color: #d17a22\" data-ng-if=\"p.decliner\" title=\"{[ p.decliner.user.first_name ]} {[ p.decliner.user.last_name ]}\">{[ p.decliner.user.first_name ]} {[ p.decliner.user.last_name ]}</span>
                                        </td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\">
                                            <span title=\"{[ p.date_approved | date:'MM/dd/yy' ]}\" data-ng-if=\"!p.date_declined\">{[ p.date_approved | date:'MM/dd/yy' ]}</span>
                                            <span style=\"color: #d17a22\" title=\"{[ p.date_declined | date:'MM/dd/yy' ]}\" data-ng-if=\"p.date_declined\">{[ p.date_declined | date:'MM/dd/yy' ]}</span>
                                        </td>
                                        <td data-ng-click=\"loadPurchaseStatic(p)\" title=\"{[ p.date_exported | date:'MM/dd/yy' ]}\">{[ p.date_exported | date:'MM/dd/yy' ]}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"uploadStatementModal\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Import Credit Card Data</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <form id=\"uploadCreditCardStatmentForm\" action=\"{[ ccStatementUrl ]}\" method=\"POST\" enctype=\"multipart/form-data\">
                            <div class=\"modal-body\">
                                <div class=\"alert alert-info\" role=\"alert\">
                                    <strong>STEP 1 Download the Credit Card Statement Template</strong>
                                </div>
                                <a href=\"/api/download/ccStatementTemplate\">
                                    <button type=\"button\" class=\"btn btn-success\">
                                        <i class=\"fa fa-fw fa-download\"></i> Download</button>
                                </a>

                                <hr>

                                <div class=\"alert alert-info\" role=\"alert\">
                                    <strong>STEP 2 Upload from Credit Card Statement File</strong>
                                </div>
                                <fieldset class=\"form-group\">
                                    <label for=\"exampleInputEmail1\">Credit Card Statement File:</label>
                                    <input type=\"file\" accept=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel\" id=\"ccFile\"
                                        name=\"ccStatementFile\" required=\"required\" maxlength=\"50\" class=\"form-control\">
                                </fieldset>
                                <fieldset class=\"form-group\">
                                    <input id=\"importCompanyId\" type=\"hidden\" name=\"companyId\" value=\"2\">
                                </fieldset>




                            </div>

                            <div class=\"modal-footer\">
                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" data-ng-click=\"SkipUploadCreditCard()\">Skip</button>
                                <button type=\"submit\" class=\"btn btn-primary\" data-ng-click=\"showLoader()\">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"prepareReconcileModal\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Filter Purchases to Reconcile</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Tick the Payment Types and Purchase Statuses to Reconcile</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <h4>Payment Type</h4>
                                    <div class=\"checkbox checkbox-primary\">
                                                <input id=\"ptAllPaymentTypes\" name=\"ptAllPaymentTypes\" data-ng-change=\"ptCheckAll()\" data-ng-init=\"ptAllChecked = true\" data-ng-model=\"ptAllChecked\"
                                                    type=\"checkbox\">
                                                <label for=\"ptAllPaymentTypes\">
                                                    All Payment Types
                                                </label>
                                    </div>
                                    <div class=\"container\" style=\"overflow-y: scroll; height:200px;\">
                                        <div class=\"row\">                                            
                                            <div class=\"col-md-12\" data-ng-repeat=\"pt in reconcilePaymentTypes\">
                                                <div class=\"checkbox checkbox-primary\">
                                                    <input id=\"pt{[pt.name]}\" name=\"pt{[pt.name]}\" data-ng-init=\"pt.checked = true\" data-ng-model=\"pt.checked\" type=\"checkbox\">
                                                    <label for=\"pt{[pt.name]}\">
                                                        {[pt.name]}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <h4>Status</h4>
                                    <div class=\"checkbox checkbox-primary\" data-ng-repeat=\"pt in listStatuses\">
                                        <input id=\"pt{[pt.name]}\" name=\"pt{[pt.name]}\" data-ng-model=\"pt.checked\" type=\"checkbox\">
                                        <label for=\"pt{[pt.name]}\">
                                            {[pt.name]}
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"reconcile()\" data-dismiss=\"modal\">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"reviewModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 95%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Review Reconciliation</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>
                                    <a href=\"javascript:void(0);\" onclick=\"\$('#reviewModal').modal('hide');\" data-ng-click=\"initReconciledModal()\">{[review.reconciled.length]} items</a> have been matched. The purchases & transactions
                                    shown below could not be matched. To manually reconcile a transaction to a purchase,
                                    place a check in both boxes and click MATCH. Click a purchase to view receipt. TIP: Unmatched
                                    items will be shown the next time you reconcile unless you DELETE them.</strong>
                            </div>
                            <div class=\"m-b-10\">
                                <button class=\"btn btn-success\" data-ng-disabled=\"isDisableMatch\" data-ng-click=\"matchUnreconciled()\">Match</button>
                                <button class=\"btn btn-danger\" data-ng-disabled=\"isDisableDelete\" data-ng-click=\"deleteItems()\">Delete</button>
                            </div>
                            <div style=\"text-align: center\">
                                <h4 data-ng-show=\"!review.unreconciled.purchases.length && !review.unreconciled.importedTransactions.length\">All possible matches have been made.</h4>
                            </div>
                            <div class=\"row\" data-ng-show=\"review.unreconciled.purchases.length || review.unreconciled.importedTransactions.length\">

                                <div class=\"col-md-8\" style=\"height: 540px;overflow: auto;\">
                                    <h4>Statement Transactions</h4>
                                    <table class=\"table purchase-table\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <!-- reviewheader -->
                                                <th style=\"width: 60px;\">
                                                    <input type=\"checkbox\" data-ng-model=\"transactionCheckAll\" data-ng-change=\"checkAll(transactionCheckAll, review.unreconciled.importedTransactions)\"
                                                    />
                                                </th>
                                                <th style=\"width: 100px;\" data-ng-click=\"sortColumnReconcileIT('account_number')\">Account</th>
                                                <th style=\"width: 115px;\" data-ng-click=\"sortColumnReconcileIT('date')\">Post Date</th>
                                                <th style=\"width: 100px;\" data-ng-click=\"sortColumnReconcileIT('amount')\">Amount</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"it in review.unreconciled.importedTransactions | orderBy:reconcileOptions.importedTransactions.sortBy:reconcileOptions.importedTransactions.reverse\">
                                                <td>
                                                    <input type=\"checkbox\" data-ng-model=\"it.checked\" data-ng-change=\"selectOnly(it, review.unreconciled.importedTransactions)\"
                                                    />
                                                </td>
                                                <td>...{[ it.account_number | limitTo: -6 ]}</td>
                                                <td>{[ it.date | date:'MM/dd/yy' ]}</td>
                                                <td>{[ it.amount | currency ]}</td>
                                                <td>{[ it.description ]}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class=\"col-md-4\" style=\"height: 540px;overflow: auto;\">
                                    <h4>Purchases</h4>
                                    <table class=\"table purchase-table hover-grey\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th>
                                                    <input type=\"checkbox\" data-ng-model=\"purchaseCheckAll\" data-ng-change=\"checkAll(purchaseCheckAll, review.unreconciled.purchases)\"
                                                    />
                                                </th>
                                                <th data-ng-click=\"sortColumnReconcileP('payment_type.name')\">Payment Type</th>
                                                <th data-ng-click=\"sortColumnReconcileP('date_of_purchase')\">Purchase Date</th>
                                                <th data-ng-click=\"sortColumnReconcileP('total_amount')\">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"p in review.unreconciled.purchases | orderBy:reconcileOptions.purchases.sortBy:reconcileOptions.purchases.reverse\">
                                                <td>
                                                    <input type=\"checkbox\" data-ng-model=\"p.checked\" data-ng-change=\"selectOnly(p, review.unreconciled.purchases)\" />
                                                </td>
                                                <td data-ng-click=\"loadPurchaseStatic(p)\">{[ p.payment_type.name ]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(p)\">{[ p.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                {#
                                                <td>{[ getTotalAmount(p) ]}</td>#}
                                                <td data-ng-click=\"loadPurchaseStatic(p)\">{[ p.total_amount | currency ]}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"submit\" class=\"btn btn-primary\" data-ng-click=\"finishReview()\">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"reconciledModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 80%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Reconciled Transactions/Purchases</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>The Transactions and Purchases below have been matched. To unmatch them, check the box and
                                    select UNMATCH.
                                </strong>
                            </div>
                            <div class=\"m-b-10\">
                                <button class=\"btn btn-danger\" data-ng-click=\"unmatchReconciled()\">Unmatch</button>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-12\">
                                    <h4>Reconciled Transactions</h4>
                                    <table class=\"table purchase-table hover-grey\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th colspan=\"5\" style=\"
                                                text-align: center;
                                                font-size: 20px;
                                                background: #3F51B5;
                                                color: #FFF;
                                                \">Statement Transactions</th>
                                                <th colspan=\"3\" style=\"
                                                text-align: center;
                                                font-size: 20px;
                                                background: #3F51B5;
                                                color: #FFF;
                                                border-left: solid 1px #FFF;
                                                \">Purchases</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>Account</th>
                                                <th>Purchase Date (Statement)</th>
                                                <th>Amount (Statement)</th>
                                                <th>Description</th>
                                                <th style=\"border-left: solid 1px #000;\">Payment Type</th>
                                                <th>Purchase Date (Purchase)</th>
                                                <th>Amount (Purchase)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"r in review.reconciled\">
                                                <td>
                                                    <input type=\"checkbox\" data-ng-model=\"r.checked\" data-ng-change=\"selectOnlyReconciled(r, review.reconciled)\" />
                                                </td>
                                                <td>X-{[ r.importedTransaction.account_number | limitTo: -5 ]}</td>
                                                <td>{[ r.importedTransaction.date | date:'MM/dd/yy' ]}</td>
                                                <td>{[ r.importedTransaction.amount ]}</td>
                                                <td>{[ r.importedTransaction.description ]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(r.purchase)\" style=\"border-left: solid 1px #000;\">{[ r.purchase.payment_type.name]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(r.purchase)\">{[ r.purchase.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                <td data-ng-click=\"loadPurchaseStatic(r.purchase)\">{[ r.purchase.total_amount ]}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" onclick=\"\$('#reviewModal').modal('show');\">Back</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"exportPreviewModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 80%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Export Reconciled Purchases</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Here are the items available for export</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-12\" style=\"height: 500px; overflow: auto;\">
                                    <h4>Reconciled Transactions</h4>
                                    <table class=\"table purchase-table\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th>Job</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Payment Type</th>
                                                <th>Class (opt)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"e in exportReviews | orderBy:['matched_imported_transaction.date','purchase.payment_type.name']\">
                                                <td>{[ e.purchase.project.name ]} ({[ e.purchase.project.number ]})</td>
                                                <td>{[ e.cost.description ]} ({[ e.cost.expense_type ]})</td>
                                                <td>{[ e.purchase.matched_imported_transaction.description ]}</td>
                                                <td>{[ e.amount ]}</td>
                                                <td>{[ e.purchase.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                <td>{[ e.purchase.payment_type.name ]}</td>
                                                <td>
                                                    <select data-ng-change=\"associateClass(e.id, e.purchase_class.id)\" data-ng-init=\"e.purchase_class.id = (!e.purchase_class.id ? 0 : e.purchase_class.id)\" data-ng-model=\"e.purchase_class.id\" data-ng-options=\"c.item.id as c.item.name for c in classes\">
                                                        <option value=\"\" ng-show=\"false\"></option>
                                                    </select>
                                                </td>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                        <div class=\"modal-footer\">
                        {% if isQbIntegrated %}                          
                        <button class=\"btn btn-primary\" data-ng-click=\"importToQuickBooks()\">Import to QuickBooks</button>
                        {% endif %}
                            <div class=\"btn-group\">
                                <button type=\"button\" class=\"btn btn-primary dropdown-toggle waves-effect waves-light\" data-toggle=\"dropdown\" aria-expanded=\"false\">Export
                                    <span class=\"caret\"></span>
                                </button>
                                <div class=\"dropdown-menu\">
                                    <a class=\"dropdown-item\" href=\"/api/company/{{ companyId }}/export?type=excel\">Excel</a>
                                    <a class=\"dropdown-item\" href=\"/api/company/{{ companyId }}/export?type=csv\">CSV</a>
                                </div>
                            </div>
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Skip</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"targetStaticPurchaseModal\">
                <div class=\"modal-dialog modal-lg\" role=\"document\" style=\"width: 70%;\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\" style=\"{[ targetPurchase.status == 'STATUS_DECLINED' ? 'background: #d17a22!important;' : '' ]}\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">
                                {[ targetPurchase.status == 'STATUS_NOT_APPROVED' ? 'UNAPPROVED PURCHASE' : '' ]} {[ targetPurchase.status == 'STATUS_APPROVED'
                                ? 'APPROVED PURCHASE' : '' ]} {[ targetPurchase.status == 'STATUS_DECLINED' ? 'DECLINED PURCHASE'
                                : '' ]}
                            </h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <div class=\"row\">
                                <div class=\"col-md-6 drift-pane\">
                                    <div class=\"row\">
                                        <div class=\"col-md-6\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Job</label>
                                                <span> {[ targetPurchase.project.name ]} ({[ targetPurchase.project.number ]})</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-6\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Submitted By: </label>
                                                <span> {[ targetPurchase.purchaser.user.first_name ]} {[ targetPurchase.purchaser.user.last_name
                                                    ]}
                                                </span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Date of Purchase</label>
                                                <span>{[ targetPurchase.date_of_purchase | date:'MM/dd/yyyy' ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\" data-ng-show=\"targetPurchase.vendor != null\">
                                            <fieldset class=\"form-group\">
                                                <label for=\"\">Vendor:</label>
                                                <span>{[ targetPurchase.vendor.name ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                             <fieldset class=\"form-group\">
                                                <label for=\"\">Payment Type</label>
                                                <span>{[ targetPurchase.payment_type.name ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                             <fieldset class=\"form-group\">
                                                <label for=\"\">Total Amount</label>
                                                <span>{[ targetPurchase.total_amount | currency ]}</span>
                                            </fieldset>
                                        </div>
                                        <div class=\"col-md-12\">
                                            <fieldsest class=\"form-group\" style=\"color: #d17a22;\" data-ng-if=\"targetPurchase.status == 'STATUS_DECLINED'\">
                                                <label for=\"\">Declined By {[targetPurchase.decliner.user.first_name]} {[targetPurchase.decliner.user.last_name]}
                                                    on {[targetPurchase.date_declined | date]}</label>
                                            </fieldsest>
                                        </div>
                                        <div class=\"col-md-12\">
                                             <fieldset class=\"form-group\" style=\"color: #d17a22;\" data-ng-if=\"targetPurchase.status == 'STATUS_DECLINED' && targetPurchase.comments.length\">
                                                <label for=\"\">Comments</label>
                                                <span>{[ targetPurchase.comments ]}</span>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                   
                                   
                                    
                                   
                                    <div style=\"text-align: right;margin-right: 20px;\">
                                        <small style=\"color: #d17a22;\">inclusive of sales tax ({[ (targetPurchase.is_override_sales_tax ? 0 : targetPurchase.sales_tax)
                                            | currency ]}) {[targetPurchase.is_override_sales_tax ? '*' : '']}</small>
                                    </div>
                                    <div class=\"p-20\" style=\"padding-top: 0!important;\" data-ng-if=\"targetPurchase.purchase_items.length\">
                                        <table class=\"table approver-table\">
                                            <tbody style=\"width: 100%;\">
                                                <tr class=\"thead-default\">
                                                    <td></td>
                                                    <td>Item</td>
                                                    <td>Amount
                                                        <small style=\"color: red;\">inclusive of sales tax ({[ (isSalesTaxOverride ? 0 : targetPurchase.sales_tax)
                                                            | currency ]}) {[isSalesTaxOverride ? '*' : '']}</small>
                                                    </td>
                                                </tr>
                                                <tr data-ng-repeat=\"pc in targetPurchase.purchase_items\" data-ng-init=\"getSalesTaxCalculated(pc)\">
                                                    <td></td>
                                                    <td data-ng-if=\"!pc.cost.hidden\">{[ pc.cost.code_number ]} {[ pc.cost.description ]} {[ pc.cost.expense_type
                                                        ]}
                                                    </td>
                                                    <td data-ng-if=\"pc.cost.hidden\">{[ pc.cost.description ]}</td>
                                                    <td style=\"text-align: right; \">{[ pc.postAmount | currency ]}</td>
                                                    <td class=\"memo\">
                                                        <div style=\"white-space: normal;\">{[ pc.memo ]}</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style=\"text-align: right; font-weight: bold;\">TOTAL:</td>
                                                    <td style=\"text-align: right; font-weight: bold;\">{[ getTotalPostAmount(targetPurchase) | currency : \"\$\" : 2 ]}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class=\"col-md-6 text-center\">
                                    <a class=\"text-center\" data-ng-href=\"{[ targetPurchase.image ]}\" style=\"text-align: center;\" data-toggle=\"lightbox\">
                                        <img data-ng-src=\"{[ targetPurchase.image ]}\" data-zoom=\"{[ targetPurchase.image ]}\" style=\"margin: 0 auto; max-height: calc(88vh - 200px);\"
                                            class=\"img-fluid receipt-image\">
                                        <p style=\"color: #d17a22;\">(Roll over image to zoom)</p>
                                    </a>
                                    {#
                                    <a class=\"text-center\" data-ng-href=\"{{ vich_uploader_asset(targetPurchase, 'imageFile') }}\" style=\"text-align: center;\"
                                        data-toggle=\"lightbox\">#} {#
                                        <img data-ng-src=\"{{ vich_uploader_asset(targetPurchase, 'imageFile') }}\" style=\"height: 350px; margin: 0 auto;\" class=\"img-fluid\">#} {#
                                        <p>(Click to Enlarge)</p>#} {#
                                    </a>#}
                                </div>
                            </div>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"button\" data-ng-if=\"targetPurchase.status == 'STATUS_NOT_APPROVED'\" class=\"btn btn-secondary tertiary\" data-ng-click=\"declinePurchase()\">Decline</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"declineCommentPurchaseModal\">
                <div class=\"modal-dialog modal-md\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Confirm Declined Purchase</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <div class=\"row\">
                                <div class=\"col-md-12\">
                                    <textarea data-ng-model=\"comment\" class=\"form-control\" placeholder=\"Type Comment Here (Optional)\" style=\"font-size: 18px;\"
                                        rows=\"10\"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
                            <button type=\"button\" class=\"btn btn-secondary tertiary\" data-ng-click=\"confirmDecline()\">Confirm Decline</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"exportCustomModal\">
                <div class=\"modal-dialog modal-lg\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Filter Purchases to Export</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\" style=\"height: calc(75vh - 200px);overflow-y: auto;\">

                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Tick the radio buttons to filter exports</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-3\">
                                    <h4>Payment Types</h4>
                                    <div>
                                        <select class=\"form-control paymenttypefilter\" title=\"All Payment Types\" multiple data-ng-model=\"paymentTypesFilterExport\"
                                            data-ng-options=\"p.id as p.name for p in listPaymentTypes\">
                                        </select>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <h4>Reconciled?</h4>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"reconcile\" data-ng-model=\"customExport.reconciled\" id=\"radioR1\" value=\"yes\" checked=\"\">
                                        <label for=\"radioR1\">
                                            Yes
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"reconcile\" data-ng-model=\"customExport.reconciled\" id=\"radioR2\" value=\"no\" checked=\"\">
                                        <label for=\"radioR2\">
                                            No
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"reconcile\" data-ng-model=\"customExport.reconciled\" id=\"radioR3\" value=\"all\" checked=\"\">
                                        <label for=\"radioR3\">
                                            All
                                        </label>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <h4>Approved?</h4>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"approved\" data-ng-model=\"customExport.approved\" id=\"radioA1\" value=\"yes\" checked=\"\">
                                        <label for=\"radioA1\">
                                            Yes
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"approved\" data-ng-model=\"customExport.approved\" id=\"radioA2\" value=\"no\" checked=\"\">
                                        <label for=\"radioA2\">
                                            No
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"approved\" data-ng-model=\"customExport.approved\" id=\"radioA3\" value=\"all\" checked=\"\">
                                        <label for=\"radioA3\">
                                            All
                                        </label>
                                    </div>
                                </div>
                                <div class=\"col-md-3\">
                                    <h4>Type?</h4>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"type\" data-ng-model=\"customExport.type\" id=\"radioT1\" value=\"excel\" checked=\"\">
                                        <label for=\"radioT1\">
                                            Excel
                                        </label>
                                    </div>
                                    <div class=\"radio\">
                                        <input type=\"radio\" name=\"type\" data-ng-model=\"customExport.type\" id=\"radioT2\" value=\"csv\" checked=\"\">
                                        <label for=\"radioT2\">
                                            CSV
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                            <button type=\"button\" class=\"btn btn-primary\" data-ng-click=\"adhocExportReview()\">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"exportAdhocPreviewModal\">
                <div class=\"modal-dialog modal-lg\" style=\"width: 80%;\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">REVIEW PURCHASES FOR EXPORT</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <div class=\"alert alert-info\" role=\"alert\">
                                <strong>Here are the items available for export</strong>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-12\" style=\"height: 500px; overflow: auto;\">
                                    <h4>Review Transactions for Export</h4>
                                    <table class=\"table purchase-table\">
                                        <thead class=\"thead-default\">
                                            <tr>
                                                <th>Job</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Payment Type</th>
                                                <th>Class (opt)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat=\"e in exportReviews | orderBy:['purchase.date_of_purchase','purchase.payment_type.name']\">
                                                <td>{[ e.purchase.project.name ]} ({[ e.purchase.project.number ]})</td>
                                                <td>{[ e.cost.code_number ]}</td>
                                                <td>{[ e.cost.description ]} ({[ e.cost.expense_type ]})</td>
                                                <td>{[ e.amount ]}</td>
                                                <td>{[ e.purchase.date_of_purchase | date:'MM/dd/yy' ]}</td>
                                                <td>{[ e.purchase.payment_type.name ]}</td>
                                                <td>
                                                    <select data-ng-change=\"associateClass(e.id, e.purchase_class.id)\" data-ng-model=\"e.purchase_class.id\" data-ng-options=\"c.item.id as c.item.name for c in classes\"></select>
                                                </td>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                            <div class=\"modal-footer\">
                                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>
                                {% if isQbIntegrated %}
                                <button class=\"btn btn-primary\" data-ng-click=\"importToQuickBooks()\">Import to QuickBooks</button>
                                {% endif %}
                                <a data-ng-href=\"/api/export/dashboard?type={[customExport.type]}&approved={[customExport.approved]}&reconciled={[customExport.reconciled]}&companyId={[customExport.companyId]}{[ paymentTypeExportQuery ]}\">
                                    <button type=\"button\" class=\"btn btn-primary\">Export</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



            <div class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" id=\"checkDuplciateTransactionsModal\">
                <div class=\"modal-dialog modal-lg\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"mySmallModalLabel\">Duplicate Transactions Detected</h5>
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">×</span>
                            </button>
                        </div>
                        <div class=\"modal-body\">
                            <h3 style=\"text-align: center;\">
                                WARNING - Some or all of these transactions have been imported previously. Importing them again could result in a large number
                                of unreconciled transactions.
                            </h3>
                        </div>

                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\" data-ng-click=\"deleteDuplicateTransactions()\">Cancel</button>
                            <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\" data-ng-click=\"openPrepareReconcileModal()\">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        {% endblock %}
        {% block stylesheets %}
        <style>
            /*
        .purchase-table th[data-ng-click]:hover {
            background: #315da6;
            color: #FFF;
            cursor: pointer;
        }

        .purchase-table th:active {
            background: #000;
            color: #FFF;
        }
        */

            .purchase-table th[data-ng-click]:hover {
                cursor: pointer;
            }

            .purchase-table th[data-ng-click] i {
                display: inline;
            }

            .purchase-table th[data-ng-click]:hover i {
                display: inline !important;
            }

            .orange {
                color: #d17a22;
            }
        </style>
        <link rel=\"stylesheet\" href=\"{{ asset('css/table.css') }}\"> 
        {% endblock %}
        {% block javascripts %}
        <script>
            \$(function () {
                \$('.dpicker').datepicker();
                new Drift(document.querySelector('.receipt-image'), {
                    paneContainer: document.querySelector('.drift-pane')
                });
            });
        </script>
        {% endblock %}", "dashboard/accountant.html.twig", "/Applications/MAMP/htdocs/projectpro-web/app/Resources/views/dashboard/accountant.html.twig");
    }
}
