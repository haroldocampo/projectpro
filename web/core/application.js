angular.module('globalLoader', [])
    .config(function ($httpProvider) {
        $httpProvider.interceptors.push('HttpInterceptorLoader');
    })
    .factory('HttpInterceptorLoader', function ($q, dependency1, dependency2) {
        return {
            // optional method
            'request': function (config) {
                angular.element('#ppro-loader').show();
                return config;
            },
            // optional method
            'requestError': function (rejection) {
                angular.element('#ppro-loader').hide();
                return $q.reject(rejection);
            },
            // optional method
            'response': function (response) {
                angular.element('#ppro-loader').hide();
                return response;
            },
            // optional method
            'responseError': function (rejection) {
                angular.element('#ppro-loader').hide();
                return $q.reject(rejection);
            }
        };
    });

var app = angular.module('ProjexApp', ['fcsa-number', 'ui.select', 'ngSanitize', 'angular-loading-bar']);

app.factory('Poller', function($http, $timeout) {
var data = { response: {}, calls: 0 };
    var poller = function() {
        var companyId = angular.element('#companyId').val();
        if(!companyId) {
            return;
        }

        if(data.stop){
            return;
        }

        $http.get('/api/company/'+companyId+'/qb/checkqueue', {
            ignoreLoadingBar: true
          }).then(function(r) {
                data.calls++;

                if(r.data && data.calls > 1){
                    data.stop = true;
                    $http.post('/api/employees/notifyqb', 
                    {}, 
                    {
                        ignoreLoadingBar: true
                    }
                    ).then(function (r) {
                    });
                }
                $timeout(poller, 120000);
        });      
    };
    poller();

    return {
        data: data
    };
});

app.run(function(Poller) {});


String.prototype.contains = function (it) {
    return this.indexOf(it) != -1;
};

app.config(function ($interpolateProvider, $sceProvider) {
    $interpolateProvider.startSymbol('{[');
    $interpolateProvider.endSymbol(']}');
    $sceProvider.enabled(false);
});

app.config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
    cfpLoadingBarProvider.spinnerTemplate = '<div id="ppro-loader"></div>';
}]);

app.directive('selectOnBlur', function() {
    return {
        require: 'uiSelect',
        link: function(scope, elm, attrs, ctrl) {
            elm.on('blur', 'input.ui-select-search', function(e) {
                if(ctrl.open && (ctrl.tagging.isActivated || ctrl.activeIndex >= 0)){
                    ctrl.select(ctrl.items[ctrl.activeIndex]);
                }
                e.target.value = '';
            });
        }
    };
})

// property filter
app.filter('propsFilter', function () {
    return function (items, props) {
        var out = [];

        if (angular.isArray(items)) {
            var keys = Object.keys(props);

            items.forEach(function (item) {
                var itemMatches = false;

                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }

        return out;
    };
});

app.directive('modalWindow', function () {
    return {
        restrict: 'EA',
        link: function (scope, element) {
            $(".modal-dialog").draggable({
                handle: ".modal-header",
            });
        }
    };
});

app.directive('keyEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.keyEnter);
                });
                event.preventDefault();
            }
        });
    };
});

app.directive('format', ['$filter', function ($filter) {
    return {
        require: '?ngModel',
        link: function (scope, elem, attrs, ctrl) {
            if (!ctrl)
                return;

            var format = {
                prefix: '$',
                centsSeparator: '.',
                thousandsSeparator: ',',
                allowNegative: true
            };

            function precisionRound(number, precision) {
                var factor = Math.pow(10, precision);
                return Math.round(number * factor) / factor;
            }

            ctrl.$parsers.unshift(function (value) {
                elem.priceFormat(format);
                if (value == '$-0.0') {
                    elem[0].value = elem[0].value.replace('$-', '$');
                } else if (value == '$-0.00') {
                    elem[0].value = elem[0].value.replace('$-', '$');
                }

                return elem[0].value;
            });

            ctrl.$formatters.unshift(function (value) {
                elem[0].value = precisionRound(ctrl.$modelValue * 100, 2);
                elem.priceFormat(format);
                //                    if(value.contains('-') && !elem[0].value.contains('-')){
                //                        elem[0].value = elem[0].value.replace('$','$-');
                //                    }

                return elem[0].value;
            });
        }
    };
}]);

app.directive('realTimeCurrency', function ($filter, $locale) {
    var decimalSep = $locale.NUMBER_FORMATS.DECIMAL_SEP;
    var toNumberRegex = new RegExp('[^0-9\\' + decimalSep + ']', 'g');
    var trailingZerosRegex = new RegExp('\\' + decimalSep + '0+$');
    var filterFunc = function (value) {
        return $filter('currency')(value);
    };

    function getCaretPosition(input) {
        if (!input)
            return 0;
        if (input.selectionStart !== undefined) {
            return input.selectionStart;
        } else if (document.selection) {
            // Curse you IE
            input.focus();
            var selection = document.selection.createRange();
            selection.moveStart('character', input.value ? -input.value.length : 0);
            return selection.text.length;
        }
        return 0;
    }

    function setCaretPosition(input, pos) {
        if (!input)
            return 0;
        if (input.offsetWidth === 0 || input.offsetHeight === 0) {
            return; // Input's hidden
        }
        if (input.setSelectionRange) {
            input.focus();
            input.setSelectionRange(pos, pos);
        } else if (input.createTextRange) {
            // Curse you IE
            var range = input.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }

    function toNumber(currencyStr) {
        return parseFloat(currencyStr.replace(toNumberRegex, ''), 10);
    }

    return {
        restrict: 'A',
        require: 'ngModel',
        link: function postLink(scope, elem, attrs, modelCtrl) {
            modelCtrl.$formatters.push(filterFunc);
            modelCtrl.$parsers.push(function (newViewValue) {
                var oldModelValue = modelCtrl.$modelValue;
                var newModelValue = toNumber(newViewValue);
                modelCtrl.$viewValue = filterFunc(newModelValue);
                var pos = getCaretPosition(elem[0]);
                elem.val(modelCtrl.$viewValue);
                var newPos = pos + modelCtrl.$viewValue.length -
                    newViewValue.length;
                if ((oldModelValue === undefined) || isNaN(oldModelValue)) {
                    newPos -= 3;
                }
                setCaretPosition(elem[0], newPos);
                return newModelValue;
            });
        }
    };
});

app.controller('ClassController', function ($scope, $http, $filter) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.newClass = {};
    $scope.newClass.name = '';
    $scope.init = function () {
        $http.get('/api/company/' + $scope.companyId + '/purchaseClassList').then(function (r) {
            $scope.classes = r.data;
            $scope.classes.shift();
        });
    };

    $scope.addPurchaseClass = function () {
        if ($scope.newClass.name == '') {
            toastr.error('Please input a name for the class.');
            return;
        }

        $http.post('/api/company/' + $scope.companyId + '/purchaseClass', $scope.newClass).then(function (r) {
            toastr.info('You have created a new purchase class', 'Add Complete!');
            $scope.newClass.name = '';
            $scope.init();
        });
    };

    $scope.deleteClass = function (item, cannotDelete) {
        if (cannotDelete) {
            toastr.error('Class cannot be deleted because purchases have been made on it.');
            return;
        }
        $http.delete('/api/purchaseclass/' + item.item.id).then(function (r) {
            toastr.info('You have deleted a class', 'Delete Complete!');
            $scope.init();
        });
    };

    $scope.init();
});


app.controller('PaymentTypeController', function ($scope, $http, $filter) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.newPaymentType = {};
    $scope.init = function () {
        $http.get('/api/company/' + $scope.companyId + '/transactionTypes').then(function (r) {
            $scope.transactionTypes = r.data;
        });

        $http.get('/api/company/' + $scope.companyId + '/paymentTypesListWeb').then(function (r) {
            $scope.paymentTypes = r.data;
        });
    };

    $scope.addPaymentType = function () {
        $http.post('/api/company/' + $scope.companyId + '/paymentTypesList', $scope.newPaymentType).then(function (r) {
            toastr.info('You have created a new payment type', 'Add Complete!');
            $scope.init();
        });
    };

    $scope.deletePaymentType = function (item, cannotDelete) {
        if (cannotDelete) {
            toastr.error('Payment type cannot be deleted because purchases have been made on it.');
            return;
        }
        $http.delete('/api/paymentTypes/' + item.id).then(function (r) {
            toastr.info('You have deleted a payment type', 'Delete Complete!');
            $scope.init();
        });
    };

    $scope.associateTransactionType = function (paymentTypeId, transactionTypeId) {
        $http.put('/api/paymentTypes/' + paymentTypeId + '/associatetransactiontype', {
            transactionTypeId: transactionTypeId
        }).then(function (r) {
            toastr.info('You have updated a payment type', 'Transaction Type Updated!');
            //$scope.init();
        });
    };

    $scope.init();
});

app.controller('AccountController', function ($scope, $http, $filter, $timeout) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.model = {
        companyName: '',
        subscriptionCost: ''
    };
    $scope.init = function () {
        $http.get('/api/company/' + $scope.companyId + '/account').then(function (r) {
            $scope.model.companyName = r.data.companyName;
            $scope.model.subscriptionCost = (r.data.billing.subscription.current_billing_amount_in_cents * .01);
            $scope.qbIntegration = r.data.isQbIntegrated;
        });
    };

    $scope.editCompanyName = function () {
        $http.put('/api/company/' + $scope.companyId + '/name', {
            name: $scope.model.companyName
        }).then(function (r) {
            toastr.success('Company Name Changed!');
            $timeout(function () {
                location.reload();
            });
        });;
        $scope.isEditing = false;
    };

    $scope.initBillingInfo = function () {
        $('#creditCartModal').modal('show');
    };
    $scope.setIntegration = function () {
        $http.post('/api/company/' + $scope.companyId + '/qbIntegration', {
            isQbIntegrated: $scope.qbIntegration
        }).then(function (r) {
            toastr.success('Successfully Toggled QB Integration!');
            if (r.data.isQbIntegrated) {
                toastr.success('Downloading QB connector!');
                var downloadLink = '/api/company/' + $scope.companyId + '/qbConnector';
                window.location.href = downloadLink;
            }
        })
    }

    $scope.init();
});

app.controller('CreditCardController', function ($scope, $http, $filter, $window) {
    var companyId = angular.element('#companyId').val();

    $http.get('/api/billing/' + companyId).then(function (r) {
        $scope.billingAddress = r.data.subscription.credit_card.billing_address;
        $scope.billingCity = r.data.subscription.credit_card.billing_city;
        $scope.billingCountry = r.data.subscription.credit_card.billing_country;
        $scope.billingState = r.data.subscription.credit_card.billing_state;
        $scope.billingEmail = r.data.subscription.customer.email;
    });

});

app.controller('CreateCompanyController', function ($scope, $http, $filter, $window) {
    $scope.addCompany = function () {
        $http.post('/api/companies', {
            name: $scope.companyName
        }).then(function (r) {
            $window.location.href = '/dashboard/company/' + r.data;
        });
    };


});

app.controller('ExpiredController', function ($scope) {
    var companyId = angular.element('#companyId').val();

    if(companyId == "79" || companyId == "3") {
        $('.modal').modal('hide');
        return;
    }

    $scope.openCreditCardModal = function () {
        $('#creditCartModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#creditCartModal .close-modal').hide();
    };

});

app.controller('CompanyController', function ($scope, $http, $filter, $window, $timeout) {
    $('.upgrade-section').hide();
    var companyId = angular.element('#companyId').val();
    $scope.billingInfo = null;
    $scope.trialDaysLeft = 0;
    $scope.processingPayment = false;

    $scope.init = function () {
        $scope.checkTrial();
    };

    $scope.checkTrial = function () {
        $http.get('/api/billing/' + companyId).then(function (r) {
            var trialData = r.data;
            if (trialData.subscription == undefined) {
                $scope.createBilling();
            } else {
                $scope.billingInfo = r.data;
                $scope.getBillingInfo();
            }
        });
    };

    $scope.getBillingInfo = function () {
        if ($scope.billingInfo) {
            $scope.finalizeBilling();
            return;
        }

        $http.get('/api/billing/' + companyId).then(function (r) {
            $scope.billingInfo = r.data;
            $scope.finalizeBilling();
        });
    };

    $scope.finalizeBilling = function () {
        if ($scope.billingInfo.subscription.state != 'trialing') {

            // IF TRIAL HAS ENDED
            if ($scope.billingInfo.subscription.state == 'past_due' || $scope.billingInfo.subscription.state == 'canceled') {
                $timeout(function () {

                    $('.upgrade-section').html('<span style="position: relative;left: 40px;">Your Trial has Ended. Buy now to continue.</span>');
                    var isAdmin = $('#isAdmin').val();

                    if (isAdmin == 'true') {
                        if ($('#creditCartModal').length) {
                            $('#creditCartModal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            return;
                        }
                        $('#expiredModalAdmin').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                    } else {
                        $('#expiredModalUser').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                    }

                });
            }
            $scope.getBillingPortalLink();
            // ELSE CONTINUE

        } else {
            return; // Commented Due to PROJ-444
            $scope.getTrialDays($scope.billingInfo);
            $scope.getBillingPortalLink();
            $('.upgrade-section').show();
            if ($scope.billingInfo.subscription.credit_card) {
                //$('.upgrade-section').html('<span style="position: relative;left: 40px;">Chargify Verification in Progress</span>');
            }
        }
    };

    $scope.getTrialDays = function (billingInfo) {
        var twoMinutes = 2 * 60 * 1000;
        var now = moment();
        var startDate = billingInfo.subscription.created_at;
        var trialEndDate = moment(billingInfo.subscription.trial_ended_at);
        $scope.trialDaysLeft = (trialEndDate.diff(now, 'days')) + 1;

        if ($scope.trialDaysLeft > 30) {
            $scope.trialDaysLeft = 30; // Max days is 30
        }

        // if (moment() > moment(billingInfo.subscription.trial_ended_at)) {
        //     $('#expiredModal').modal({
        //         backdrop: 'static',
        //         keyboard: false
        //     });
        //     $('.close-modal').hide();
        //     $scope.trialDaysLeft = 0;
        // }

        if (billingInfo.subscription.state === 'past_due' || billingInfo.subscription.state === 'trial_ended' || billingInfo.subscription.state === 'expired' || billingInfo.subscription.state === 'canceled') {
            $('#expiredModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.close-modal').hide();
            $scope.trialDaysLeft = 0;
            return;
        }

        // more states to be handled: on_hold, soft_failure, trailing, unpaid

        if (moment().isSameOrAfter(moment(billingInfo.subscription.next_assessment_at))) {
            $scope.processingPayment = true;
        } else {
            $scope.processingPayment = false;
        }

        if (moment().isSameOrAfter(moment(billingInfo.subscription.trial_ended_at))) { // if trial expires

            if (billingInfo.subscription.credit_card) {
                return;
            }

            $('#expiredModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.close-modal').hide();
            $scope.trialDaysLeft = 0;
            $scope.processingPayment = false;
        }


    };

    $scope.createBilling = function () {
        $http.post('/api/billing/create', {
            companyId: companyId
        }).then(function (r) {
            $scope.getBillingInfo();
        });
    };

    $scope.getBillingPortalLink = function () {
        // Save Billing Portal Link in Company Account Table
        $http.get('/api/billing/' + companyId + '/portal').then(function (r) {
            $scope.billingPortalLink = r.data;
        });
    };

    $scope.init();
});




app.controller('UserManagementController', function ($scope, $http, $filter, $timeout) {
    var vm = this;
    $scope.companyId = angular.element('#companyId').val();
    $scope.newUser = {};
    $scope.listRoles = [{
        name: "approver"
    }, {
        name: "accountant"
    }, {
        name: "admin"
    }, {
        name: "purchaser",
        checked: true
    }];
    $scope.listDays = [{
        name: "Monday"
    }, {
        name: "Tuesday"
    }, {
        name: "Wednesday"
    }, {
        name: "Thursday"
    }, {
        name: "Friday"
    }];

    $scope.init = function () {
        $http.get('/api/company/' + $scope.companyId + '/employees').then(function (r) {
            $scope.users = r.data;

            $timeout(function () {
                $('.ui-select-container').click(function () {
                    var $this = $(this);
                    $this.find('.ui-select-search').get(0).focus()
                    $this.find('.ui-select-search').get(0).click()
                });
            });
        });
    };

    $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
        vm.paymentTypes = r.data;
    });

    vm.singleDemo = {};
    vm.singleDemo.color = '';
    vm.multipleDemo = {};

    vm.tagSelected = function ($item, $model) {
        $http.post('/api/company/' + $scope.companyId + '/employee/paymentTypes/add', {
            name: $item.name,
            employeeId: $scope.targetEmployee.id
        }).then(function (r) {
            $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
                vm.paymentTypes = r.data;
            });
        });
    };    

    vm.onRemove = function ($item, $model) {
        $http.post('/api/company/' + $scope.companyId + '/employee/paymentTypes/remove', {
            itemId: $item.id,
            name: $item.name,
            employeeId: $scope.targetEmployee.id
        }).then(function (r) {
            $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
                vm.paymentTypes = r.data;
            });
        });
    };

    $scope.removed = function ($item, $model) {
        $http.post('/api/company/' + $scope.companyId + '/employee/paymentTypes/remove', {
            itemId: $item.id,
            name: $item.name,
            employeeId: $scope.targetEmployee.id
        }).then(function (r) {
            $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
                vm.paymentTypes = r.data;
            });
        });
    };

    vm.tagTransform = function (newTag) {
        var item = {
            name: newTag
        };

        return item;
    };

    $scope.formatRoleText = function (role) {
        return role.replace("ROLE_", "");;
    };

    $scope.initAddUser = function () {
        vm.multipleDemo.selectedPeople = [];
        $scope.openAddUser();
    };

    $scope.init();

    $scope.addUser = function () {
        $scope.newUser.roles = $scope.getRoles($scope.listRoles);
        $scope.newUser.companyId = angular.element('#companyId').val();
        $scope.newUser.paymentTypes = $scope.getPaymentTypes(vm.multipleDemo.selectedPeople);

        //return;
        $http.post('/api/company/' + $scope.newUser.companyId + '/employees', $scope.newUser).then(function (r) {
            if (r.data.success == true) {
                toastr.info(r.data.message);
                $scope.init();
                $scope.newUser = {};

                $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
                    vm.paymentTypes = r.data;
                });

                $http.get('/api/company/' + $scope.companyId + '/employees').then(function (r) {
                    $scope.users = r.data;
                    $scope.listRoles = [{
                        name: "approver"
                    }, {
                        name: "accountant"
                    }, {
                        name: "admin"
                    }, {
                        name: "purchaser",
                        checked: true
                    }];
                    
                    $('#adduserModal').modal('hide');
                    location.reload();
                });

                $http.get('/api/billing/' + $scope.companyId + '/update').then(function (r) {});


            } else {
                toastr.error(r.data.errorMessage, 'Error');
            }
        });
    };
    $scope.openAddUser = function () {
        $scope.newUser.firstName = "";
        $scope.newUser.lastName = "";
        $scope.newUser.email = "";
        $scope.listRoles = [{
            name: "approver"
        }, {
            name: "accountant"
        }, {
            name: "admin"
        }, {
            name: "purchaser",
            checked: true
        }];
        $('#adduserModal').modal('show');
    }

    $scope.getPaymentTypes = function (paymentTypes) {
        var selected = [];
        for (var i in paymentTypes) {
            var r = paymentTypes[i];
            selected.push(r.name);
        }

        return selected;
    };

    $scope.initEditUser = function (u) {
        $scope.listRoles = [{
            name: "approver",
            tmp: 'ROLE_APPROVER'
        }, {
            name: "accountant",
            tmp: 'ROLE_ACCOUNTANT'
        }, {
            name: "admin",
            tmp: 'ROLE_ADMIN'
        }, {
            name: "purchaser",
            checked: true
        }];
        $scope.targetUser = angular.copy(u.user);
        $scope.targetEmployee = angular.copy(u);
        var currentRoles = u.roles;
        vm.multipleDemo.selectedPeople = [];
        for (var i in vm.paymentTypes) {
            var item = vm.paymentTypes[i];
            for (var j in item.employee_payment_types) {
                if (item.employee_payment_types[j].employeeId == $scope.targetEmployee.id) {
                    vm.multipleDemo.selectedPeople.push(item);
                }
            }
        }
        //vm.multipleDemo.selectedPeople = [vm.people[5], vm.people[4]];

        for (var i in currentRoles) {
            var crole = currentRoles[i];

            for (var j in $scope.listRoles) {
                var lrole = $scope.listRoles[j];

                if (lrole.tmp == crole) {
                    lrole.checked = true;
                }
            }
        }

        $('#edituserModal').modal('show');
    };
    $scope.employeeId = $('#employeeId').val();
    $scope.editUser = function () {
        $scope.targetUser.roles = $scope.getRoles($scope.listRoles);

        if ($scope.employeeId == $scope.targetEmployee.id) {
            $('.accountant-link').addClass('invisible');
            $('.approver-link').addClass('invisible');
            $('.admin-link').addClass('invisible');
            for (var i in $scope.targetUser.roles) {
                switch ($scope.targetUser.roles[i]) {
                    case 'accountant':
                        $('.accountant-link').removeClass('invisible');
                        break;
                    case 'approver':
                        $('.approver-link').removeClass('invisible');
                        break;
                    case 'admin':
                        $('.admin-link').removeClass('invisible');
                        break;
                }
            }
        }

        $http.put('/api/employees/' + $scope.targetEmployee.id, $scope.targetUser).then(function (r) {
            $scope.init();
            toastr.success('You have updated this user!');
            $scope.listRoles = [{
                name: "approver"
            }, {
                name: "accountant"
            }, {
                name: "admin"
            }, {
                name: "purchaser",
                checked: true
            }];
            $('#edituserModal').modal('hide');
        });
    };

    $scope.deleteUser = function (id) {
        $http.delete('/api/employees/' + id).then(function (r) {
            $scope.init();
            toastr.success('You have disabled this user!');
        });
    };

    $scope.getRoles = function (roles) {
        var selected = [];
        for (var i in roles) {
            r = roles[i];
            if (r.checked == true) {
                selected.push(r.name);

            }
        }

        return selected;
    };
});

app.controller('RegisterController', function ($scope, $http) {

});

app.controller('AccountantDashboardController', function ($scope, $http, $sce, $timeout) {
    $scope.statusFilter = 'STATUS_APPROVED';
    $scope.approverFilter = {
        unapprovedCount: 0,
        employee: {
            id: 0
        }
    };
    $scope.companyId = angular.element('#companyId').val();
    $scope.employeeId = angular.element('#employeeId').val();
    $scope.sortBy = ['date_of_purchase', 'payment_type.name'];
    $scope.reverse = false;
    $scope.toReconcile = {};
    $scope.ccStatementUrl = '/api/company/' + $scope.companyId + '/import/ccStatement';
    $scope.customExport = {};
    $scope.isDisableDelete = true;
    $scope.reconciledFilter = '0';
    $scope.exportedFilter = '0';
    $scope.customExport = {
        companyId: $scope.companyId,
        reconciled: 'all',
        approved: 'yes',
        type: 'excel',
        paymentType: []
    };
    $scope.reconcilePaymentTypes = [];
    $scope.ptAllChecked = true;
    $scope.isFilterDates = false;
    $scope.paymentTypeExportQuery = '';
    $scope.changeStatusCount = 0;
    $scope.paymentTypesFilterExport = [];
    $scope.reconcileOptions = {
        importedTransactions: {
            sortBy: ['account_number', 'date', 'amount'],
            reverse: false
        },
        purchases: {
            sortBy: ['payment_type.name', 'date_of_purchase'],
            reverse: false
        }
    };

    $scope.SkipUploadCreditCard = function () {
        $('#prepareReconcileModal').modal('show');
    };

    $scope.openPrepareReconcileModal = function () {
        $('.modal').modal('hide');
        $('#prepareReconcileModal').modal('show');
    };

    $scope.showLoader = function () {
        $('body').append('<div id="ppro-loader" style="position: fixed;"></div>');
    };

    $scope.deleteDuplicateTransactions = function () {
        $http.delete('/api/company/' + $scope.companyId + '/importedTransactions/deleteduplicates').then(function (r) {
            $('#prepareReconcileModal').modal('show');
        });
    };

    $scope.$watch('paymentTypesFilterExport', function (newVal, oldVal) {
        if (newVal == oldVal) {
            return;
        }

        if (!newVal.length) {
            $scope.paymentTypeExportQuery = '';
            return;
        }

        var result = '';
        for (var i in newVal) {
            var item = newVal[i];
            result += '&paymentType[]=' + item;
        }

        $scope.paymentTypeExportQuery = result;
    });

    $scope.loadPurchaseStatic = function (p) {
        $scope.targetPurchase = p;
        $scope.newPurchaseItem = {
            purchaseId: p.id
        };
        //$http.get('/api/project/' + p.project.id + '/costs').then(function (r) {
        //    $scope.costs = r.data.costs;
        //});
        $('#targetStaticPurchaseModal').modal('show');
    };

    $scope.getTotalAmount = function (purchase) {
        var total = 0;
        for (var i in purchase.purchase_items) {
            var item = purchase.purchase_items[i];
            total += (parseFloat(item.amount));
        }
        var result = Math.round(total * 100) / 100;
        return result;
    };

    $scope.getTotalAmountPurchases = function () {
        var total = 0;
        for (var i in $scope.filteredPurchases) {
            var item = $scope.filteredPurchases[i];
            total += (parseFloat(item.total_amount));
        }
        var result = Math.round(total * 100) / 100;
        return result;
    };

    $scope.getTotalPostAmount = function (purchase) {
        var total = 0;
        for (var i in purchase.purchase_items) {
            var item = purchase.purchase_items[i];
            total += Math.round(parseFloat(item.postAmount) * 100) / 100;
        }
        return Math.round(total * 100) / 100;
    };

    $scope.getSalesTaxCalculated = function (pc) {
        if ($scope.targetPurchase.is_override_sales_tax) {
            pc.postAmount = pc.amount;
            return;
        }
        var salesTax = $scope.targetPurchase.sales_tax;
        var totalAmount = $scope.targetPurchase.total_amount;
        var costs = $scope.targetPurchase.purchase_items;

        var tmpTotal = 0;
        //for (var i in costs) {
        //    tmpTotal += costs[i].amount;
        //}

        //var percentage = (pc.amount / (tmpTotal));
        //var calc = ((percentage * salesTax) + pc.amount);
        //pc.postAmount = Math.round(calc * 100) / 100;
        pc.postAmount = pc.taxed_amount;
    };

    $scope.changeStatusFilter = function () {
        if ($scope.changeStatusCount < 1) {
            $http.get('/api/company/' + $scope.companyId + '/purchases').then(function (r) {
                $scope.purchases = r.data.purchases;
                angular.forEach($scope.purchases, function (purchase) {
                    purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                });
            });
        }
        $scope.changeStatusCount++;
    };

    $scope.initPurchases = function () {
        $http.get('/api/company/' + $scope.companyId + '/unapprovedpurchases').then(function (r) {
            $scope.purchases = r.data.purchases;
            angular.forEach($scope.purchases, function (purchase) {
                purchase.date_of_purchase = new Date(purchase.date_of_purchase);
            });
        });

        $http.get('/api/company/' + $scope.companyId + '/approversfilter/').then(function (r) {
            var unapprovedCount = $scope.getAllUnapprovedCount(r.data);
            $scope.approvers = r.data;
            $scope.approvers.unshift({
                employee: {
                    id: 0,
                    company: {},
                    user: {
                        "id": 0,
                        "email": "",
                        "first_name": "ALL APPROVERS",
                        "last_name": ""
                    },
                    roles: [],
                    date_time_created: "0000-00-00T00:13:55-07:00"
                },
                unapprovedCount: unapprovedCount
            });
            $scope.approverFilter = $scope.approvers[0];
        });

        $http.get('/api/company/' + $scope.companyId + '/allPaymentTypesList').then(function (r) {
            $scope.listPaymentTypes = r.data;
            $scope.reconcilePaymentTypes = angular.copy(r.data);
            var allPaymentTypes = {
                id: 'ALL',
                name: 'All Payment Types',
                filterOnly: true
            };
            $timeout(function () {
                $('.paymenttypefilter').selectpicker();
            });
            $scope.paymentTypesFilter = [];
        });

        $http.get('/api/company/' + $scope.companyId + '/purchaseClassList').then(function (r) {
            $scope.classes = r.data;
        });

        $scope.listStatuses = [{
            name: "Approved",
            value: 'approved',
            checked: true
        }, {
            name: "Not approved",
            value: 'not_approved',
            checked: false
        }];;
    };

    $scope.associateClass = function (purchaseId, classId) {
        $http.post('/api/purchase/' + purchaseId + '/associatepurchaseclass', {
            classId: classId
        }).then(function (r) {
            toastr.info('You have updated a purchase', 'Class Updated!');
        });
    };

    $scope.getAllUnapprovedCount = function (approvers) {
        var count = 0;
        for (var i in approvers) {
            var a = approvers[i];
            count += a.unapprovedCount;
        }
        return count;
    };

    $scope.ptCheckAll = function () {
        for (var i in $scope.reconcilePaymentTypes) {
            var item = $scope.reconcilePaymentTypes[i];
            item.checked = $scope.ptAllChecked;
        }
    };

    $scope.initImportCreditStatement = function () {
        $('#importCompanyId').val($scope.companyId);
        $('#uploadStatementModal').modal('show');
        $("#ccFile").val("");
        $scope.transactionCheckAll = false;
        $scope.listStatuses = [{
            name: "Approved",
            value: 'approved',
            checked: true
        }, {
            name: "Not approved",
            value: 'not_approved',
            checked: false
        }];
    };

    $scope.matchUnreconciled = function () {
        $scope.toMatch = {};
        var targetImport = $scope.getSelected($scope.review.unreconciled.importedTransactions);
        var targetPurchase = $scope.getSelected($scope.review.unreconciled.purchases);

        $scope.toMatch.purchaseId = targetPurchase.id;
        $scope.toMatch.importedTransactionId = targetImport.id;
        $scope.toMatch.action = 'match';

        $http.post('/api/reconcile/manual', $scope.toMatch).then(function (r) {
            $scope.refreshMatched();
            //$('#reconciledModal').modal('show');
        });
    };
    $scope.isDisableMatch = true;


    $scope.disableMatch = function () {

    };

    $scope.unmatchReconciled = function () {
        $scope.toMatch = {};
        var target = $scope.getSelected($scope.review.reconciled);

        $scope.toMatch.purchaseId = target.purchase.id;
        $scope.toMatch.importedTransactionId = target.importedTransaction.id;
        $scope.toMatch.action = 'unmatch';

        $http.post('/api/reconcile/manual', $scope.toMatch).then(function (r) {
            $scope.refreshUnmatched();
            //$('#reconciledModal').modal('hide');
        });
    };

    $scope.refreshUnmatched = function () {
        var target = $scope.getSelected($scope.review.reconciled);

        $scope.deleteFromArray(target, $scope.review.reconciled);

        $scope.review.unreconciled.importedTransactions.push(target.importedTransaction);
        $scope.review.unreconciled.purchases.push(target.purchase);
    };

    $scope.refreshMatched = function () {
        var targetImport = $scope.getSelected($scope.review.unreconciled.importedTransactions);
        var targetPurchase = $scope.getSelected($scope.review.unreconciled.purchases);


        $scope.deleteFromArray(targetImport, $scope.review.unreconciled.importedTransactions);
        $scope.deleteFromArray(targetPurchase, $scope.review.unreconciled.purchases);

        $scope.review.reconciled.push({
            importedTransaction: targetImport,
            purchase: targetPurchase
        });
    };

    $scope.initReconciledModal = function () {
        $('#reconciledModal').modal('show');
    };

    $scope.sortColumn = function (column) {
        if ($scope.sortBy != column) {
            $scope.reverse = false;
        } else {
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortBy = column;
    };

    $scope.sortColumnApproved = function (column) {
        for (var i in $scope.filteredPurchases) {
            $scope.filteredPurchases[i].date_approved = $scope.filteredPurchases[i].date_declined ? $scope.filteredPurchases[i].date_declined : $scope.filteredPurchases[i].date_approved;
        }

        if ($scope.sortBy != column) {
            $scope.reverse = false;
        } else {
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortBy = column;
    };

    $scope.sortColumnReconcileIT = function (column) {
        if ($scope.reconcileOptions.importedTransactions.sortBy != column) {
            $scope.reconcileOptions.importedTransactions.reverse = false;
        } else {
            $scope.reconcileOptions.importedTransactions.reverse = !$scope.reconcileOptions.importedTransactions.reverse;
        }
        $scope.reconcileOptions.importedTransactions.sortBy = column;
    };

    $scope.sortColumnReconcileP = function (column) {
        if ($scope.reconcileOptions.purchases.sortBy != column) {
            $scope.reconcileOptions.purchases.reverse = false;
        } else {
            $scope.reconcileOptions.purchases.reverse = !$scope.reconcileOptions.purchases.reverse;
        }
        $scope.reconcileOptions.purchases.sortBy = column;
    };

    $scope.deleteItems = function () {
        var targetPurchases = $scope.getAllSelected($scope.review.unreconciled.purchases);
        var targetImports = $scope.getAllSelected($scope.review.unreconciled.importedTransactions);

        for (var i in targetPurchases) {
            var targetPurchase = targetPurchases[i];
            $http.delete('/api/purchase/' + targetPurchase.id).then(function (r) {
                //toastr.success('Purchase Deleted!');
            });
            $scope.deleteFromArray(targetPurchase, $scope.review.unreconciled.purchases);
        }

        for (var i in targetImports) {
            var targetImport = targetImports[i];
            $http.delete('/api/importedTransactions/' + targetImport.id).then(function (r) {
                //toastr.success('Transaction Deleted!');
            });
            $scope.deleteFromArray(targetImport, $scope.review.unreconciled.importedTransactions);
        }
        toastr.success('Items Deleted!');
    };

    $scope.finishReview = function () {
        $http.get('/api/company/' + $scope.companyId + '/export/list').then(function (r) {
            $('.modal').modal('hide');
            $scope.exportReviews = r.data;
            $('#exportPreviewModal').modal('show');
        });
    };

    $scope.exportCurrent = function () {

    };

    $scope.exportCustom = function () {
        //$scope.customExport = '';

    };

    $scope.adhocExport = function () {
        $('#exportCustomModal').modal('show');
    };

    $scope.adhocExportReview = function () {
        $scope.customExport.paymentType = $scope.paymentTypesFilterExport;
        $http.post('/api/company/' + $scope.companyId + '/export/adhoclist', $scope.customExport).then(function (r) {
            $('.modal').modal('hide');
            $scope.exportReviews = Object.values(r.data);
            $('#exportAdhocPreviewModal').modal('show');
        });
    };

    window.groupBy = function (xs, key) {
        return xs.reduce(function (rv, x) {
            (rv[x[key]] = rv[x[key]] || []).push(x);
            return rv;
        }, {});
    };


    window.groupByArray = function (xs, key) {
        return xs.reduce(function (rv, x) {
            let v = key instanceof Function ? key(x) : x[key];
            let el = rv.find((r) => r && r.key === v);
            if (el) {
                el.values.push(x);
            } else {
                rv.push({
                    key: v,
                    values: [x]
                });
            }
            return rv;
        }, []);
    }

    $scope.importToQuickBooks = function () {
        var importItems = $scope.exportReviews;
        var projects = [];
        var classes = [];
        var costCodes = [];
        var purchaseItems = [];
        var purchases = [];

        for (var i in importItems) {
            var item = importItems[i];
            projects = $scope.appendIfNotExisting(projects, item.purchase.project, 'name');
            classes = $scope.appendIfNotExisting(classes, item.purchase_class, 'name');

            if(item.purchase.date_imported){
                //continue; // Do not import again
            }
            var trimmed_cost_code = (item.cost.code_number).trim();
            
            //var cost_code = trimmed_cost_code.replace("·", "-");
            //var payment_type = item.purchase.payment_type.name.replace("·", "-");
            var cost_code = trimmed_cost_code.replace(/·/g, "-");
            var payment_type = item.purchase.payment_type.name.replace(/·/g, "-");

            purchaseItems.push({
                'id': item.id,
                // 'cost_code': (item.cost.code_number + ' ' + item.cost.description).trim(), // REFERENCE COSTCODEDESCRIPTION
                // 'description': (item.cost.code_number + ' ' + item.cost.description).trim(), // REFERENCE COSTCODEDESCRIPTION
                'cost_code': cost_code, // REFERENCE COSTCODEDESCRIPTION
                'description': cost_code, // REFERENCE COSTCODEDESCRIPTION
                'quantity': 1,
                'cost_class': item.cost.cost_class,
                'memo': item.memo,
                'amount': item.amount,
                'purchase_date' : $scope.formatPurchaseDateQB(item.purchase.date_of_purchase),
                'total_amount': item.purchase.total_amount, 
                'vendor': item.purchase.vendor ? item.purchase.vendor.name : null,
                'payment_type': payment_type,
                'transaction_type': item.purchase.payment_type.transaction_type ? item.purchase.payment_type.transaction_type.name : null,
                'purchase_class': item.purchase_class ? item.purchase_class.name : null,
                // 'project': (item.purchase.project.customer ? (item.purchase.project.customer + ':') : '') + item.purchase.project.name,
                'project': ((item.purchase.project.customer && item.purchase.project.customer != 'No Customer:No Job') ? (item.purchase.project.customer) : null),
                'purchase_id': item.purchase.id,
            });

            purchases = groupByArray(purchaseItems, 'purchase_id');
        }

        var importRequest = {
            projects: projects,
            classes: classes,
            cost_codes: costCodes,
            purchases: purchases,
            employeeId: $scope.employeeId,
            companyId: $scope.companyId
        };

        $http.post('/qb/project-pro/import_items.php', {
            import: importRequest
        }).then(function (r) {
            alert('We will email you when the import to QuickBooks is complete! Check your inbox for the results of the import.');
            location.reload();
        });

        $http.post('/api/employees/'+$scope.employeeId+'/importedqb', {}).then(function (r) {
        });

        console.log(importRequest);
    };

    $scope.formatPurchaseDateQB = function(dateOfPurchase){
        var pruchaseDate = '';

        var split = dateOfPurchase.split('/');

        purchaseDate = split[2] + '-' + split[0] + '-' +split[1];

        return purchaseDate;
    };

    $scope.appendIfNotExisting = function (array, item, identifier) {
        if (!item) {
            return array;
        }
        for (var i in array) {
            if (array[i][identifier] == item[identifier]) {
                return array;
            }
        }

        array.push(item);
        return array;
    }

    $scope.selectOnly = function (selected, arr) {
        //        for (var i in arr) {
        //            var item = arr[i];
        //            if (item.id != selected.id) {
        //                item.checked = false;
        //            }
        //        }

        $scope.watchMathcing();
    };

    $scope.deleteFromArray = function (selected, arr) {
        arr.splice(arr.indexOf(selected), 1);
    };

    $scope.deleteFromArrayHash = function (selected, arr) {
        //        for(var i in arr){
        //            var item = arr[i];
        //            if(selected.$$hashKey == item.$$hashKey){
        //                arr.splice(i,);
        //            }
        //        }
        //        arr.splice(arr.indexOf(selected));
    };

    $scope.selectOnlyReconciled = function (selected, arr) {
        for (var i in arr) {
            var item = arr[i];
            if (item.importedTransaction.id != selected.importedTransaction.id) {
                item.checked = false;
            }
        }
    };


    $scope.getSelected = function (arr) {
        for (var i in arr) {
            var item = arr[i];
            if (item.checked) {
                return item;
            }
        }
    };

    $scope.getAllSelected = function (arr) {
        var items = [];
        for (var i in arr) {
            var item = arr[i];
            if (item.checked) {
                items.push(item);
            }
        }
        return items;
    };

    $scope.getTotalAmount = function (purchase) {
        var total = 0;
        for (var i in purchase.purchase_items) {
            var item = purchase.purchase_items[i];
            total += parseFloat(item.amount);
        }
        return total;
    };

    $scope.checkAll = function (isCheck, arr) {
        for (var i in arr) {
            var item = arr[i];
            item.checked = isCheck;
        }

        $scope.watchMathcing();
    };

    $scope.watchMathcing = function () {
        var transactions = $scope.review.unreconciled.importedTransactions;
        var purchases = $scope.review.unreconciled.purchases;
        var transactionsCount = 0;
        var purchasesCount = 0;

        for (var i in transactions) {
            var item = transactions[i];
            if (item.checked) {
                transactionsCount++;
            }
        }

        for (var i in purchases) {
            var item = purchases[i];
            if (item.checked) {
                purchasesCount++;
            }
        }

        if (purchasesCount == 1 && transactionsCount == 1) {
            $scope.isDisableMatch = false;
        } else {
            $scope.isDisableMatch = true;
        }

        var selectedCount = purchasesCount + transactionsCount;
        if (selectedCount >= 1) {
            $scope.isDisableDelete = false;
        } else {
            $scope.isDisableDelete = true;
        }

    };

    $scope.reconcile = function () {
        $scope.toReconcile.paymentTypes = $scope.getPaymentTypes($scope.reconcilePaymentTypes);
        $scope.toReconcile.statuses = $scope.getStatuses($scope.listStatuses);

        $http.post('/api/company/' + $scope.companyId + '/reconcile', $scope.toReconcile).then(function (r) {
            toastr.success('Review reconciled/unreconciled items.', 'Reconcile Complete!');
            // Check if any unreconciled is an array or not
            $scope.postProcessReconciliation(r.data);
            $('#reviewModal').modal('show');
        });
    };

    $scope.postProcessReconciliation = function (data) {
        // Check if purchases is array
        if (data.unreconciled.purchases != Array) {
            var urPurchases = [];
            for (var i in data.unreconciled.purchases) {
                urPurchases.push(data.unreconciled.purchases[i]);
            }
            data.unreconciled.purchases = urPurchases;
        }
        $scope.review = data;
    };

    $scope.contains = function (needle) {
        // Per spec, the way to identify NaN is that it is not equal to itself
        var findNaN = needle !== needle;
        var indexOf;

        if (!findNaN && typeof Array.prototype.indexOf === 'function') {
            indexOf = Array.prototype.indexOf;
        } else {
            indexOf = function (needle) {
                var i = -1,
                    index = -1;

                for (i = 0; i < this.length; i++) {
                    var item = this[i];

                    if ((findNaN && item !== item) || item === needle) {
                        index = i;
                        break;
                    }
                }

                return index;
            };
        }

        return indexOf.call(this, needle) > -1;
    };

    $scope.search = function (row) {
        return (angular.lowercase(row.project.name + ' ' + row.project.number).indexOf(angular.lowercase($scope.projectFilter) || '') !== -1) &&
            (((angular.lowercase(row.status) == angular.lowercase($scope.statusFilter)) || $scope.statusFilter == 'ALL')) &&
            ($scope.approverFilter.employee.id == row.project.approver.id || $scope.approverFilter.employee.id == 0) &&
            (($scope.reconciledFilter == 1 && row.matched_imported_transaction != undefined) || ($scope.reconciledFilter == 0 && row.matched_imported_transaction == undefined) || $scope.reconciledFilter == 'ALL') &&
            (($scope.exportedFilter == 1 && row.date_exported != undefined) || ($scope.exportedFilter == 0 && row.date_exported == undefined) || $scope.exportedFilter == 'ALL') &&
            ($scope.contains.call($scope.paymentTypesFilter, row.payment_type.id) || $scope.paymentTypesFilter.length == 0) &&
            (!$scope.isFilterDates || !$scope.filterDateStart || !$scope.filterDateEnd || (Date.parse(row.date_of_purchase) >= Date.parse($scope.filterDateStart) && Date.parse(row.date_of_purchase) <= Date.parse($scope.filterDateEnd)));
    };

    $scope.getPaymentTypes = function (roles) {
        var selected = [];
        for (var i in roles) {
            r = roles[i];
            if (r.checked == true) {
                selected.push(r.id);

            }
        }

        return selected;
    };
    $scope.getStatuses = function (roles) {
        var selected = [];
        for (var i in roles) {
            r = roles[i];
            if (r.checked == true) {
                selected.push(r.value);
            }
        }

        return selected;
    };

    $scope.declinePurchase = function () {
        $('.modal').modal('hide');
        $('#declineCommentPurchaseModal').modal('show');
    };

    $scope.confirmDecline = function () {
        $http.post('/api/purchases/' + $scope.targetPurchase.id + '/decline', {
            comment: $scope.comment,
            employeeId: $scope.employeeId
        }).then(function (d) {
            toastr.success('Purchase has been declined!');
            $scope.targetPurchase.status = 'STATUS_DECLINED';

            $http.get('/api/company/' + $scope.companyId + '/purchases').then(function (r) {
                $scope.purchases = r.data.purchases;
                angular.forEach($scope.purchases, function (purchase) {
                    purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                });
                $('#declineCommentPurchaseModal').modal('hide');
            });
        });
    };

    $scope.initPurchases();

});

app.controller('ApproverDashboardController', function ($scope, $http, $timeout) {
    $scope.approverFilter = {
        unapprovedCount: 0,
        employee: {
            id: 0
        }
    };
    $scope.companyId = angular.element('#companyId').val();
    $scope.employeeId = angular.element('#employeeId').val();
    $scope.sortBy = 'date_of_purchase';
    $scope.reverse = false;
    $scope.statusFilter = 'STATUS_NOT_APPROVED';
    $scope.changeStatusCount = 0;
    $scope.isSalesTaxOverride = false;
    $scope.hasPendingPurchaseItem = false;
    $scope.isNewVendor = false;
    $scope.qbIntegration = false;
    $scope.initProjects = function () {
        $http.get('/api/company/' + $scope.companyId + '/account').then(function (r) {
            $scope.qbIntegration = r.data.isQbIntegrated;
        });

        $http.get('/api/company/' + $scope.companyId + '/approver/unapprovedpurchases').then(function (r) {
            $scope.projects = r.data.projects;
            angular.forEach($scope.projects, function (project) {
                angular.forEach(project.purchases, function (purchase) {
                    purchase.date_of_purchase_string = purchase.date_of_purchase; // save string value first
                    purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                });
            });

            $timeout(function () {
                $('.ui-select-container').click(function () {
                    var $this = $(this);
                    $this.find('.ui-select-search').get(0).focus()
                    $this.find('.ui-select-search').get(0).click()
                });
            });
        });
        $http.get('/api/company/' + $scope.companyId + '/approversfilter/').then(function (r) {
            var unapprovedCount = $scope.getAllUnapprovedCount(r.data);
            $scope.approvers = r.data;
            $scope.approvers.unshift({
                employee: {
                    id: 0,
                    company: {},
                    user: {
                        "id": 0,
                        "email": "",
                        "first_name": "ALL APPROVERS",
                        "last_name": ""
                    },
                    roles: [],
                    date_time_created: "0000-00-00T00:13:55-07:00"
                },
                unapprovedCount: unapprovedCount
            });
            $scope.getSelectedApprover();            
        });
        $http.get('/api/company/' + $scope.companyId + '/vendors').then(function (r) {
            $scope.vendors = r.data.vendors;
        });
        $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
            $scope.paymentTypes = r.data;
        });
        $http.get('/api/company/' + $scope.companyId + '/paymentTypesList').then(function (r) {
            $scope.paymentTypes = r.data;                        
        });        
    };
    $scope.setSearch = function (search) {
        // if (search != '')
            $scope.vendorName = search;
    }
    $scope.tagSelected = function ($item) {
        if ($item == null && $scope.vendorName == null) {
            return;
        } else if ($item == null && $scope.vendorName != '') {
            $scope.isNewVendor = true;
            $scope.targetPurchase.vendor = {
                name: $scope.vendorName,
                purchaser: $scope.employeeId,
                company: $scope.companyId
            }
            // $http.post('/api/company/' + $scope.companyId + '/vendors', {
            //     name: $scope.vendorName,                
            //     purchaser: $scope.employeeId
            // }).then(function (r){                       
            //     if(r.data.isNewVendor)
            //         toastr.success('New Vendor has been created!');                
            //     var v = r.data.vendor;
            //     $http.get('/api/company/' + $scope.companyId + '/vendors').then(function (r) {
            //         $scope.vendors = r.data.vendors;  
            //         $scope.setVendor(v);
            //     });            

            // });

        } else if ($item.id == null) {
            $scope.isNewVendor = true;
            $scope.targetPurchase.vendor = {
                name: $scope.vendorName,
                purchaser: $scope.employeeId,
                company: $scope.companyId
            }
            //     $http.post('/api/company/' + $scope.companyId + '/vendors', {
            //         name: $item,                
            //         purchaser: $scope.employeeId
            //     }).then(function (r){                
            //         if(r.data.isNewVendor)
            //             toastr.success('New Vendor has been created!');                
            //         var v = r.data.vendor;
            //         $http.get('/api/company/' + $scope.companyId + '/vendors').then(function (r) {
            //             $scope.vendors = r.data.vendors;  
            //             $scope.setVendor(v);
            //         });         
            //     });
        } else {
            $scope.isNewVendor = false;
            $scope.targetPurchase.vendor = $item;
            console.log($item);
            // $scope.setVendor($item);      
        }

    };
    $scope.addVendor = function (vendor) {
        $http.post('/api/company/' + $scope.companyId + '/vendors', vendor).then(function (r) {
            if (r.data.isNewVendor)
                toastr.success('New Vendor has been created!');
            var v = r.data.vendor;
            $http.get('/api/company/' + $scope.companyId + '/vendors').then(function (r) {
                $scope.vendors = r.data.vendors;
                $scope.setVendor(v);
            });
        });
    }
    $scope.setVendor = function (vendor) {        
            $scope.targetPurchase.vendor = vendor;
            $http.post('/api/purchases/' + $scope.targetPurchase.id + '/vendor', {
                vendor: $scope.targetPurchase.vendor.id
            }).then(function (r) {
                if (r.data.isNewVendor)
                    toastr.success('New Vendor has been created!');                
            });        
    }
    $scope.clearVendor = function ($event, $select){ 
        $scope.targetPurchase.vendor = null;        
        //stops click event bubbling
        $event.stopPropagation(); 
        //to allow empty field, in order to force a selection remove the following line
        $select.selected = undefined;
        //reset search query
        $select.search = undefined;
        //focus and open dropdown
        $select.activate();
    }
    $scope.changeStatusFilter = function () {
        if ($scope.changeStatusCount < 1) {
            $scope.loadPurchases();
        }
        $scope.changeStatusCount++;
    };

    $scope.getUnapprovedFromProject = function (purchases) {
        var count = 0;
        for (var i in purchases) {
            var p = purchases[i];
            if (p.status == 'STATUS_NOT_APPROVED') {
                count++;
            }
        }
        return count;
    };

    $scope.getAllUnapprovedCount = function (approvers) {
        var count = 0;
        for (var i in approvers) {
            var a = approvers[i];
            count += a.unapprovedCount;
        }
        return count;
    };

    $scope.loadPurchases = function () {
        $http.get('/api/company/' + $scope.companyId + '/approver/purchases').then(function (r) {
            $scope.projects = r.data.projects;
            angular.forEach($scope.projects, function (project) {
                angular.forEach(project.purchases, function (purchase) {
                    purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                });
            });
            $scope.$apply();
        });
    };

    $scope.getSelectedApprover = function () {
        for (var i in $scope.approvers) {
            var item = $scope.approvers[i];
            if (item.employee.id == $scope.employeeId) {
                $scope.approverFilter = $scope.approvers[i];
                return;
            }
        }
        $scope.approverFilter = $scope.approvers[0];
    };

    $scope.deletePurchaseItem = function (id, pc) {
        $http.delete('/api/purchaseItems/' + id).then(function (r) {
            toastr.success('Purchase has been deleted!');
            $scope.targetPurchase.purchase_items.splice($scope.targetPurchase.purchase_items.indexOf(pc), 1);
        });
    };

    $scope.getTotalAmount = function (purchase) {
        var total = 0;
        for (var i in purchase.purchase_items) {
            var item = purchase.purchase_items[i];
            total += (parseFloat(item.amount));
        }
        var result = Math.round(total * 100) / 100;
        return result;
    };

    $scope.getTotalPostAmount = function (purchase) {
        if (!purchase){
            return;
        }

        var total = 0;
        for (var i in purchase.purchase_items) {
            var item = purchase.purchase_items[i];
            total += Math.round(parseFloat(item.postAmount) * 100) / 100;
        }
        return Math.round(total * 100) / 100;
    };

    $scope.getSalesTaxCalculated = function (pc) {
        if ($scope.isSalesTaxOverride || $scope.targetPurchase.is_override_sales_tax) {
            pc.postAmount = pc.amount;
            return;
        }

        var salesTax = $scope.targetPurchase.sales_tax;
        var totalAmount = $scope.targetPurchase.total_amount;
        var costs = $scope.targetPurchase.purchase_items;

        //var tmpTotal = 0;
        //for (var i in costs) {
        //    tmpTotal = totalAmount;
        //}

        //var percentage = (pc.amount / (tmpTotal));
        //var calc = ((percentage * salesTax) + pc.amount);
        //pc.postAmount = Math.round(calc * 100) / 100;
        pc.postAmount = pc.taxed_amount;
    };

    $scope.sortColumn = function (column) {
        if ($scope.sortBy != column) {
            $scope.reverse = false;
        } else {
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortBy = column;
    };

    $scope.search = function (row) {
        return (((angular.lowercase(row.status) == angular.lowercase($scope.statusFilter)) || $scope.statusFilter == 'ALL')) &&
            ($scope.approverFilter.employee.id == row.project.approver.id || $scope.approverFilter.employee.id == 0);
        // ||angular.lowercase(row.model).indexOf(angular.lowercase($scope.query) || '') !== -1);
    };

    $scope.addPurchaseItem = function () {
        $scope.newPurchaseItem.amount = parseFloat($scope.newPurchaseItem.amount.replace('$', '').replace(',', '').trim());
        $http.post('/api/purchaseItems', $scope.newPurchaseItem).then(function (d) {
            toastr.success('Purchase has been added!');
            var newItem = d.data;
            $scope.targetPurchase.purchase_items.push(newItem);
            $scope.hasPendingPurchaseItem = false;
            // Set Items back to default value after
            $scope.newPurchaseItem.costId = 0;
            $scope.newPurchaseItem.amount = 0;
            $scope.newPurchaseItem.memo = '';

            if ($scope.changeStatusCount == 0) {
                $http.get('/api/company/' + $scope.companyId + '/approver/unapprovedpurchases').then(function (r) {
                    $scope.projects = r.data.projects;
                    angular.forEach($scope.projects, function (project) {
                        angular.forEach(project.purchases, function (purchase) {
                            purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                        });
                    });
                    $scope.openActiveProject($scope.targetPurchase.project.id);
                });
            } else {
                $http.get('/api/company/' + $scope.companyId + '/approver/purchases').then(function (r) {
                    $scope.projects = r.data.projects;
                    angular.forEach($scope.projects, function (project) {
                        angular.forEach(project.purchases, function (purchase) {
                            purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                        });
                    });
                    $scope.openActiveProject($scope.targetPurchase.project.id);
                });
            }
        });
    };

    $scope.approvePurchase = function () {
        if ($scope.hasPendingPurchaseItem) {
            $scope.pendingAction = 'approve';
            $('#targetPurchaseModal').modal('hide');
            $('#pendingPurchaseItem').modal('show');
        } else {
            if($scope.targetPurchase.vendor == null){
                alert('A vendor must be selected!');
                return;
            }
            $scope.updatePurchase(true);
            $http.post('/api/purchases/' + $scope.targetPurchase.id + '/approve', {
                employeeId: $scope.employeeId
            }).then(function (d) {
                toastr.success('Purchase has been approved!');
                $scope.targetPurchase.status = 'STATUS_APPROVED';
                $('#targetPurchaseModal').modal('hide');
                if ($scope.changeStatusCount == 0) {
                    $http.get('/api/company/' + $scope.companyId + '/approver/unapprovedpurchases').then(function (r) {
                        $scope.projects = r.data.projects;
                        angular.forEach($scope.projects, function (project) {
                            angular.forEach(project.purchases, function (purchase) {
                                purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                            });
                        });
                        $scope.openActiveProject($scope.targetPurchase.project.id);
                    });
                } else {
                    $http.get('/api/company/' + $scope.companyId + '/approver/purchases').then(function (r) {
                        $scope.projects = r.data.projects;
                        angular.forEach($scope.projects, function (project) {
                            angular.forEach(project.purchases, function (purchase) {
                                purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                            });
                        });
                        $scope.openActiveProject($scope.targetPurchase.project.id);
                    });
                }

            });
        }
    };

    $scope.declinePurchase = function () {
        if ($scope.hasPendingPurchaseItem) {
            $scope.pendingAction = 'decline';
            $('#targetPurchaseModal').modal('hide');
            $('#pendingPurchaseItem').modal('show');
        } else {
            $scope.comment = '';
            $('.modal').modal('hide');
            $('#declineCommentPurchaseModal').modal('show');
        }
    };

    $scope.confirmDecline = function () {
        $http.post('/api/purchases/' + $scope.targetPurchase.id + '/decline', {
            comment: $scope.comment,
            employeeId: $scope.employeeId
        }).then(function (d) {
            toastr.success('Purchase has been declined!');
            $scope.targetPurchase.status = 'STATUS_DECLINED';

            $http.get('/api/company/' + $scope.companyId + '/approver/purchases').then(function (r) {
                $scope.projects = r.data.projects;
                angular.forEach($scope.projects, function (project) {
                    angular.forEach(project.purchases, function (purchase) {
                        purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                    });
                });
                $scope.openActiveProject($scope.targetPurchase.project.id);
                $('#declineCommentPurchaseModal').modal('hide');
            });
        });
    };

    $scope.updatePurchase = function (isApprove) {
        if ($scope.hasPendingPurchaseItem) {
            $scope.pendingAction = 'update';
            $('#targetPurchaseModal').modal('hide');
            $('#pendingPurchaseItem').modal('show');
        } else {
            if($scope.qbIntegration){
                if($scope.targetPurchase.vendor == null){
                    alert('A vendor must be selected!');
                    return;
                }
            }

            if (!$scope.qbImport)
                $scope.targetPurchase.qb_import = 'DISABLED';
            else {
                $scope.targetPurchase.qb_import = 'DISABLED';
            }

            var toUpdate = {
                projectId: $scope.targetPurchase.project.id,
                totalAmount: $scope.targetPurchase.total_amount,
                date_of_purchase: $scope.targetPurchase.date_of_purchase,
                paymentTypeId: $scope.targetPurchase.payment_type.id,
                isSalesTaxOverride: $scope.isSalesTaxOverride,
                qb_import: $scope.targetPurchase.qb_import,
                isNewVendor: $scope.isNewVendor,
                vendor: $scope.targetPurchase.vendor
            };
            console.log("to Update: ");
            console.log(toUpdate);

            if (typeof toUpdate.totalAmount == 'string') {
                toUpdate.totalAmount = parseFloat(toUpdate.totalAmount.replace('$', '').replace(',', '').trim());
                $scope.targetPurchase.total_amount = toUpdate.totalAmount;
            }
            // if($scope.isNewVendor)
            //     $scope.addVendor($scope.targetPurchase.vendor);
            // else
            //     $scope.setVendor($scope.targetPurchase.vendor);

            
            toUpdate.items = $scope.targetPurchase.purchase_items;
            $scope.updateAmountWithSalesTax();
            $http.put('/api/purchases/' + $scope.targetPurchase.id, toUpdate).then(function (d) {
                toastr.success('Purchase has been updated!');
                if (d.data.isNewVendor)
                    toastr.success('New Vendor has been created!');  
                $('#targetPurchaseModal').modal('hide');                              
                if (!isApprove) {
                    if ($scope.changeStatusCount == 0) {
                        
                        $http.get('/api/company/' + $scope.companyId + '/approver/unapprovedpurchases').then(function (r) {
                            $scope.projects = r.data.projects;
                            angular.forEach($scope.projects, function (project) {
                                angular.forEach(project.purchases, function (purchase) {
                                    purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                                });
                            });                            
                            $scope.openActiveProject($scope.targetPurchase.project.id);
                        });
                    } else {
                        $http.get('/api/company/' + $scope.companyId + '/approver/purchases').then(function (r) {
                            $scope.projects = r.data.projects;
                            angular.forEach($scope.projects, function (project) {
                                angular.forEach(project.purchases, function (purchase) {
                                    purchase.date_of_purchase = new Date(purchase.date_of_purchase);
                                });
                            });
                            $scope.openActiveProject($scope.targetPurchase.project.id);
                        });
                    }
                }
            });
        }

    };

    $scope.rememberSelectedPurchaseItem = function () {
        $scope.hasPendingPurchaseItem = true;
    };

    $scope.continuePurchaseAction = function () {
        $scope.hasPendingPurchaseItem = false;
        $('#pendingPurchaseItem').modal('hide');
        $('#targetPurchaseModal').modal('show');
        if ($scope.pendingAction == 'update')
            $scope.updatePurchase();
        else if ($scope.pendingAction == 'approve')
            $scope.approvePurchase();
        else if ($scope.pendingAction == 'decline')
            $scope.declinePurchase();
        else if ($scope.pendingAction == 'close')
            $scope.closePurchaseModal();
    };
    $scope.cancelPurchaseAction = function () {
        $('#targetPurchaseModal').modal('show');
        $('#pendingPurchaseItem').modal('hide');
    };

    $scope.openActiveProject = function (id) {
        for (var i in $scope.projects) {
            var p = $scope.projects[i];
            if (p.id == id) {
                p.aactive = true;
            }
        }
    };

    $scope.activateSalesTaxOverride = function () {
        if ($scope.isSalesTaxOverride) {
            return;
        }
        //$scope.isSalesTaxOverride = confirm('Creating your own custom amounts will override the Sales Tax. If you wish to proceed press "OK"');
        $scope.isSalesTaxOverride = true;
    };

    $scope.updateAmountWithSalesTax = function () {
        var salesTax = $scope.targetPurchase.sales_tax;
        var totalAmount = $scope.targetPurchase.total_amount;
        var costs = $scope.targetPurchase.purchase_items;

        for (var i in $scope.targetPurchase.purchase_items) {
            var item = $scope.targetPurchase.purchase_items[i];
            var postAmount = item.postAmount;
            if (typeof item.postAmount === 'string' || item.postAmount instanceof String) {
                postAmount = parseFloat(item.postAmount.replace('$', '').replace(',', '').trim());
            }

            //var percentage = (postAmount / totalAmount);
            //item.amount = (postAmount - (percentage * salesTax));
            item.amount = (postAmount);
        }
    };

    $scope.projectSearch = function (row) {
        return (angular.lowercase(row.project.name + ' ' + row.project.number).indexOf(angular.lowercase($scope.projectFilter) || '') !== -1) &&
            ($scope.approverFilter.employee.id == row.project.approver.id || $scope.approverFilter.employee.id == 0);
        // ||angular.lowercase(row.model).indexOf(angular.lowercase($scope.query) || '') !== -1);
    };

    $scope.closePurchaseModal = function () {
        if ($scope.hasPendingPurchaseItem) {
            $scope.pendingAction = 'close';
            $('#targetPurchaseModal').modal('hide');
            $('#pendingPurchaseItem').modal('show');
        } else {
            $scope.targetPurchase = {};
            $('#targetPurchaseModal').modal('hide');
        }

    };

    $scope.getRemainingBudget = function(pc){
        var c = pc.cost;
        for(var i in $scope.costs){
            var cost = $scope.costs[i];
            if(cost.id == pc.cost.id){
                c = cost;
                break;
            }
        }
        ///api/costs/{id}/budget
        $http.get('/api/costs/' + c.id + '/budget').then(function (r) {
            pc.budgetAmount = c.budget_amount;
            pc.approvedAmount = r.data;
            pc.remainingAmount = pc.budgetAmount - pc.approvedAmount;
        });
    };

    $scope.loadPurchase = function (p) {
        $scope.targetPurchase = angular.copy(p);
        $scope.isSalesTaxOverride = $scope.targetPurchase.is_override_sales_tax;
        $scope.newPurchaseItem = {
            purchaseId: p.id
        };
        console.log($scope.targetPurchase);
        if ($scope.targetPurchase.qb_import != 'DISABLED')
            $scope.qbImport = true;
        else
            $scope.qbImport = false;
        $timeout(function () {
            var targetDate = $scope.targetPurchase.date_of_purchase_string.split('/');
            targetDate[0] -= 1;
            $('.dpicker').datepicker('update', new Date(targetDate[2], targetDate[0], targetDate[1]));
        });
        $http.get('/api/project/' + p.project.id + '/costs').then(function (r) {
            $scope.costs = r.data.costs;
        });
        $('#targetPurchaseModal').modal('show');
        $scope.hasPendingPurchaseItem = false;
    };

    $scope.loadPurchaseStatic = function (p) {
        if (p.status == 'STATUS_NOT_APPROVED' && p.date_imported == null) {
            $scope.loadPurchase(p);
            return;
        }
        $scope.targetPurchase = p;
        $scope.newPurchaseItem = {
            purchaseId: p.id
        };
        //$http.get('/api/project/' + p.project.id + '/costs').then(function (r) {
        //    $scope.costs = r.data.costs;
        //});
        $('#targetStaticPurchaseModal').modal('show');
    };

    //$('#targetPurchaseModal').on('hidden', function () {
    //    $scope.targetPurchase = {};
    //});

    $scope.initProjects();
});

app.controller('ProjectsController', function ($scope, $http, $timeout) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.isQbIntegrated = angular.element('#isQbIntegrated').val();
    $scope.toggleCostParam = {};
    $scope.approvers = [];
    $scope.newProject = {};
    $scope.newCost = {};
    $scope.newProject.approver = {};
    $scope.newProject.isNewApprover = false;
    $scope.isDoneCostCode = false;
    $scope.validName = true;
    $scope.validApprover = true;
    $scope.customerJobs = [];
    $scope.targetProject = {};
    $scope.isAllToCost = false;
    $scope.isAllToExpense = false;
    $scope.isAllToNotify = false;
    var vm = this;

    $scope.init = function () {
        $http.get('/api/company/' + $scope.companyId + '/projects').then(function (r) {
            $scope.projects = r.data.projects;
        });

        $http.get('/api/company/' + $scope.companyId + '/approvers/').then(function (r) {
            $scope.approvers = r.data;
            $scope.approvers.push({
                id: 0,
                user: {
                    first_name: 'Not Listed (Create New Approver)',
                    last_name: ''
                }
            });
        });

        $http.get('/api/users/isDone/cci').then(function (r) {
            $scope.isDoneCostCode = r.data.isDone;
        });

        $http.get('/api/company/' + $scope.companyId + '/customerJobs').then(function (r) {
            $scope.customerJobs = r.data;
            $scope.customerJobs.unshift({id: 0, name: 'No Customer:No Job'});
        });

    };

    $scope.tagSelected = function ($item, $model) {
        if($item.name){
            $item = $item.name;
        }

        if($item.endsWith(":")){
            $item = $item.replace(':','');
            $item = $item.trim();
        }

        $scope.targetProject.customerJob = $item;
        $scope.newProject.customer = $item;

        if($item == 'No Customer:No Job'){
            return;
        }

        $http.post('/api/company/' + $scope.companyId + '/customerJob', {
            name: $item
        }).then(function (r) {
            $http.get('/api/company/' + $scope.companyId + '/customerJobs').then(function (r) {
                $scope.customerJobs = r.data;
                $scope.customerJobs.unshift({id: 0, name: 'No Customer:No Job'});
            });
        });
    };    

    $scope.disableInstruction = function () {
        $http.post('/api/users/current/setDoneDuplicate', {
            type: 'costCode'
        }).then(function (r) {
            $scope.isDoneCostCode = true;
        });
        $scope.isDoneCostCode = true;
    };

    $scope.closeAddModal = function () {
        var isClose = confirm('If you close this, all your unsaved changes will be lost. Continue?');

        if (isClose) {
            $scope.newProject = {};
            $scope.newProject.approver = {};
            $scope.newProject.isNewApprover = false;
            $scope.selectedApprover = null;
            $('#addProjectModal').modal('hide');
        } else {
            return;
        }
    };
    $scope.closeTargetProjectModal = function () {        
        if($scope.isQbIntegrated == false){
            $('#targetProjectModal').modal('hide');
            return true;
        }
        else{
            let hasNullCostClass = false;
            let untouchedTargetProject;
            //angular.forEach($scope.projects, function (project, key){
            //    if(project.id == $scope.targetProject.id){
            //        untouchedTargetProject = project;
            //    }
            //});
            angular.forEach($scope.targetProject.costs, function(cost, key){
                if(cost.cost_class == null){
                    hasNullCostClass = true;
                }
            });
            if(hasNullCostClass){
                toastr.error('Please select if the item is cost item/expense', 'Oops!');
                return false;
            }
            else{
                $('#targetProjectModal').modal('hide');
                return true;
            }
        }
        
    };

    $scope.addProject = function () {
        $scope.newProject.companyId = angular.element('#companyId').val();
        console.log($scope.selectedApprover);
        console.log($scope.newProject.name);
        if($scope.selectedApprover == null)
            $scope.validApprover = false;
        else
            $scope.validApprover = true;
        if($scope.newProject.name == null || $scope.newProject.name == "")
            $scope.validName = false;
        else
            $scope.validName = true;
        if(!$scope.validApprover || !$scope.validName)
            return;
        $http.post('/api/projects', $scope.newProject).then(function (r) {
            $scope.newProject = {};
            $scope.newProject.approver = {};
            $scope.newProject.isNewApprover = false;
            $scope.selectedApprover = null;
            if (r.data.success == false) {
                if (r.data.duplicate)
                    toastr.error('The job name is already taken', 'Oops!');
                else
                    toastr.error('You have entered an invalid email format', 'Oops!');
                return;
            }

            toastr.success('You have created a new job', 'Add Complete!');
            $scope.loadProject(r.data.projectId);
            $scope.newUser = {};

            $http.get('/api/company/' + $scope.companyId + '/projects').then(function (r) {
                $scope.projects = r.data.projects;
                $('#addProjectModal').modal('hide');
            });

            $http.get('/api/company/' + $scope.companyId + '/approvers').then(function (r) {
                $scope.approvers = r.data;
                $scope.approvers.push({
                    id: 0,
                    user: {
                        first_name: 'Not Listed (Create New Approver)',
                        last_name: ''
                    }
                });
            });
        });
    };

    $scope.addNewCost = function () {
        $scope.newCost.projectId = $scope.targetProject.id;
        $http.post('/api/costs', $scope.newCost).then(function (r) {
            console.log('New Cost');
            console.log(r);
            toastr.success('You have created a new item', 'Add Item Complete!');
            $scope.newCost = {};
            // $scope.loadProject($scope.targetProject.id);
        });

    };

    $scope.addNewCostAdhoc = function () {

        if (!$scope.newCost.codeNumber) {
            alert('Please fill in all fields for the new item.');
            return;
        }

        $scope.newCost.projectId = $scope.targetProject.id;
        $http.post('/api/costs', $scope.newCost).then(function (r) {
            toastr.success('You have created a new item', 'Add item Complete!');
            $scope.newCost = {};
            console.log('New Cost');
            console.log(r.data.cost);
            $scope.targetProject.costs.push(r.data.cost);
            // $http.get('/api/projects/' + $scope.targetProject.id).then(function (r) {
            //     $scope.targetProject = r.data.project;
            //     $scope.targetProject.approver = r.data.project.approver.id;
            //     $scope.targetProject.costs = r.data.costs;
            //     $('#targetProjectModal').modal('show');
            // });
        });

    };

    $scope.loadProject = function (id) {
        $scope.isAllToCost = false;
        $scope.isAllToExpense = false;
        $http.get('/api/projects/' + id).then(function (r) {
            $scope.targetProject = r.data.project;
            $scope.targetProject.approver = r.data.project.approver.id;
            $scope.targetProject.costs = r.data.costs;
            $scope.targetProject.customerJob = r.data.project.customer;

            if(!r.data.project.customer) {
                $scope.targetProject.customerJob = 'No Customer:No Job';
            }
            

            if (!$scope.isDoneCostCode) {

                $('#purchaseInstructionsModal').modal({
                    show: true
                });

            }

            $('#targetProjectModal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });;
            
        });
    };

    $scope.allToCostItem = function(){
        for(var i in $scope.targetProject.costs){
            $scope.targetProject.costs[i].cost_class = 'ITEM';
        }
        $scope.isAllToCost = true;
        $scope.isAllToExpense = false;
    };

    $scope.allToExpense = function(){
        for(var i in $scope.targetProject.costs){
            $scope.targetProject.costs[i].cost_class = 'EXPENSE';
        }
        $scope.isAllToCost = false;
        $scope.isAllToExpense = true;
    };

    $scope.allToNotify = function(){
        $scope.isAllToNotify = !$scope.isAllToNotify;
        for(var i in $scope.targetProject.costs){
            $scope.targetProject.costs[i].notify = $scope.isAllToNotify;
        }
    };

    $scope.showNextStepsHelp = function () {
        //toastr.info('Return to the Manage Projects screen under settings in ProjectPro and import the completed template to the correct project.', 'Step 4', {timeOut: 15000});
        //toastr.info('Follow instructions found on the template to transfer data to columns.', 'Step 3', {timeOut: 15000});
        //toastr.info('You have downloaded the template!', 'Download Complete!', {timeOut: 3000});
    };

    $scope.updateCurrentProject = function () {
        // if same email, just apdate approver
        var updateProject = {};
        updateProject.name = $scope.targetProject.name;
        updateProject.customer = $scope.targetProject.customerJob;
        updateProject.number = $scope.targetProject.number;
        updateProject.approver = $scope.targetProject.approver;
        updateProject.isNewApprover = $scope.targetProject.isNewApprover == null ? false : $scope.targetProject.isNewApprover;
        updateProject.costs = $scope.targetProject.costs;
        console.log(updateProject.costs);
        if(!$scope.closeTargetProjectModal()){
            return;
        }
        $http.put('/api/projects/' + $scope.targetProject.id, updateProject).then(function (r) {
            toastr.success('Job has been updated!');
            $('#targetProjectModal').modal('hide');
            $scope.refreshProjects($scope.targetProject.id);
        });
    };

    $scope.saveCostCode = function(c){
        $http.put('/api/costs/' + c.id, c).then(function (r) {
            toastr.success('Cost has been updated!');
            c.isEditing = false;
        });
    }

    $scope.refreshProjects = function (id) {
        $http.get('/api/company/' + $scope.companyId + '/approvers').then(function (r) {
            $scope.approvers = r.data;
            $scope.approvers.push({
                id: 0,
                user: {
                    first_name: 'Not Listed (Create New Approver)',
                    last_name: ''
                }
            });
        });

        $http.get('/api/projects/' + id).then(function (r) {
            $scope.targetProject = r.data.project;
            $scope.targetProject.approver = r.data.project.approver.id;
            $scope.targetProject.costs = r.data.costs;
        });
        // Refresh Project List
        $http.get('/api/company/' + $scope.companyId + '/projects').then(function (r) {
            $scope.projects = r.data.projects;
            $('#targetProjectModal').modal('hide');
        });
    };

    $scope.initToggleCostItems = function (cost) {
        $scope.toggleCostParam = {
            isAllExpenseTypes: false,
            isAllProjects: false
        };
        $scope.targetCostItem = cost;

        if(!$scope.targetCostItem.expense_type || $scope.targetCostItem.expense_type == ''){
            $scope.toggleCostItems(false);
            return;
        }

        $('#allowExpenseTypesModal').modal('show');
    };

    $scope.toggleCostItems = function (isAllProjects) {
        $scope.toggleCostParam.isAllProjects = isAllProjects;
        $scope.toggleCostParam.action = $scope.targetCostItem.enabled;
        $http.post('/api/costs/' + $scope.targetCostItem.id + '/toggle', $scope.toggleCostParam).then(function (r) {
            toastr.success('Item has been updated!');

            $scope.loadProject($scope.targetProject.id);
            $('#allowExpenseTypesModal').modal('hide');
        });
    };

    $scope.deleteProject = function (id) {
        $http.delete('/api/project/' + id).then(function (r) {
            toastr.success('You have deleted the job', 'Delete Complete!');
            $scope.init();
        });
    };

    $scope.deleteCost = function (id) {
        $http.delete('/api/costs/' + id).then(function (r) {
            if (r.data) {
                toastr.success('Item has been deleted!');
                $scope.loadProject($scope.targetProject.id);
            } else {
                toastr.error('Sorry, this ITEM cannot be deleted. Some purchases are currently associated with it.');
            }
        });
    };

    $scope.assignApprover = function (v) {
        $scope.newProject.approver = {};
        if (v == 0) {
            $scope.newProject.isNewApprover = true;
        } else {
            $scope.newProject.isNewApprover = false;
            $scope.newProject.approver.id = v;

            $timeout(function () {
                $scope.tmpApprover = $('#assignApprover option:selected').text();
            });
        }
    };

    $scope.assignApproverUpdate = function (v) {
        if (v == 0) {
            $scope.targetProject.approver = {};
            $scope.targetProject.isNewApprover = true;
        } else {
            $scope.targetProject.isNewApprover = false;
            $scope.targetProject.approver.id = v;

            $timeout(function () {
                $scope.tmpApprover = $('#assignApprover option:selected').text();
            });
        }
    };

    $scope.initBudgetUpload = function (id) {
        $('#uploadProjectId').val(id);
        $('#budgetFile').val(null);
    };

    $scope.init();

});

app.controller('ReminderController', function ($scope, $http) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.listDaysA = [{
        name: "M",
        value: 'DAY_MONDAY'
    }, {
        name: "T",
        value: 'DAY_TUESDAY'
    }, {
        name: "W",
        value: 'DAY_WEDNESDAY'
    }, {
        name: "TH",
        value: 'DAY_THURSDAY'
    }, {
        name: "F",
        value: 'DAY_FRIDAY'
    }];
    $scope.listDaysP = [{
        name: "M",
        value: 'DAY_MONDAY'
    }, {
        name: "T",
        value: 'DAY_TUESDAY'
    }, {
        name: "W",
        value: 'DAY_WEDNESDAY'
    }, {
        name: "TH",
        value: 'DAY_THURSDAY'
    }, {
        name: "F",
        value: 'DAY_FRIDAY'
    }];
    $scope.sendReminderPurchasers = function () {

        $http.post('/api/reminder/all', {
            to: 'purchaser',
            companyId: $scope.companyId
        }).then(function (r) {
            toastr.success('You sent reminders now!', 'Purchaser Reminder!');
            $('.modal').modal('hide');
        });
    };

    $scope.sendReminderApprovers = function () {
        $http.post('/api/reminder/all', {
            to: 'approver',
            companyId: $scope.companyId
        }).then(function (r) {
            toastr.success('You sent reminders now!', 'Approver Reminder!');
            $('.modal').modal('hide');
        });
    };

    $scope.scheduleReminderPurchasers = function () {
        var days = $scope.getDays($scope.listDaysP);
        $http.post('/api/reminder/scheduled/set', {
            type: 'purchaser',
            companyId: $scope.companyId,
            days: days
        }).then(function (r) {
            toastr.success('You have successfully scheduled reminders!', 'Purchaser Reminder');
            $('.modal').modal('hide');
            //$scope.listDaysP = [{name: "M", value: 'DAY_MONDAY'}, {name: "T", value: 'DAY_TUESDAY'}, {name: "W", value: 'DAY_WEDNESDAY'}, {name: "TH", value: 'DAY_THURSDAY'}, {name: "F", value: 'DAY_FRIDAY'}];
        });
    };

    $scope.scheduleReminderApprovers = function () {
        var days = $scope.getDays($scope.listDaysA);
        $http.post('/api/reminder/scheduled/set', {
            type: 'approver',
            companyId: $scope.companyId,
            days: days
        }).then(function (r) {
            toastr.success('You have successfully scheduled reminders!', 'Approver Reminder');
            $('.modal').modal('hide');
            //$scope.listDaysA = [{name: "M", value: 'DAY_MONDAY'}, {name: "T", value: 'DAY_TUESDAY'}, {name: "W", value: 'DAY_WEDNESDAY'}, {name: "TH", value: 'DAY_THURSDAY'}, {name: "F", value: 'DAY_FRIDAY'}];
        });
    };

    $scope.getScheduledRemindersPurchaser = function () {
        return;
        $http.post('/api/company/' + $scope.companyId + '/reminder/scheduled', {
            type: 'TYPE_PURCHASER'
        }).then(function (r) {
            $scope.initScheduledDays($scope.listDaysP, r.data.days);
        });
    };

    $scope.getScheduledRemindersApprover = function () {
        return;
        $http.post('/api/company/' + $scope.companyId + '/reminder/scheduled', {
            type: 'TYPE_APPROVER'
        }).then(function (r) {
            $scope.initScheduledDays($scope.listDaysA, r.data.days);
        });
    };

    $scope.initScheduledDays = function (listDays, scheduledDays) {
        for (var i in listDays) {
            var day = listDays[i];
            for (var j in scheduledDays) {
                var scheduledDay = scheduledDays[j];
                if (day.value == scheduledDay) {
                    day.checked = true;
                }
            }
        }
    };

    $scope.getDays = function (roles) {
        var selected = [];
        for (var i in roles) {
            r = roles[i];
            if (r.checked == true) {
                selected.push(r.name.toLowerCase());

            }
        }

        return selected;
    };

});

app.controller('CompaniesController', function ($scope, $http) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.companies = [];
    $scope.selectedCompany = '';
    $scope.init = function () {
        $http.get('/api/users/' + applicationUserId + '/companies').then(function (r) {
            $scope.companies = r.data;
            for (var i in $scope.companies) {
                var co = $scope.companies[i];

                if (co.id == $scope.companyId) {
                    $scope.selectedCompany = co.name;
                }
            }
        });
    };
    $scope.init();
});

app.controller('VendorController', function ($scope, $http) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.employeeId = angular.element('#employeeId').val();
    $scope.newName = '';
    $scope.validName = true;
    $scope.init = function () {
        $http.get('/api/company/' + $scope.companyId + '/vendors').then(function (r) {
            $scope.vendors = r.data.vendors;
        });
    };
    $scope.setMergeItem = function (vendor) {        
        $scope.mergeItem = vendor;
    }
    $scope.addVendor = function () {        
        if($scope.newName.length > 0){
            $scope.validName = true;
            $http.post('/api/company/' + $scope.companyId + '/vendors', {
                name: $scope.newName,
                purchaser: $scope.employeeId,
                sendMail: true
            }).then(function (r) {
                $scope.newName = "";
                if (r.data.isNewVendor)
                    toastr.info('You have created a new vendor', 'Add Complete!');
                else
                    toastr.info('Vendor already exists try using another name', 'Vendor Name Taken!');
                $scope.init();
            });
        }else{
            $scope.validName = false;
            // toastr.error("Vendor name cannot be blank")
        }
        
    }
    $scope.editVendor = function (vendor) {
        $http.put('/api/vendors/' + vendor.id, {
            name: vendor.name
        }).then(function (r) {
            console.log(r.data);
            if (r.data.updated == 'unique')
                toastr.success('Vendor Name Changed!');
            else if (r.data.updated == 'exists')
                toastr.warning('Vendor Name Already Exists!');

            $scope.init();
        });
        $scope.isEditing = false;
    }
    $scope.mergeVendors = function (vendor) {
        $http.post('/api/vendors/' + vendor.id, {
            mergeId: $scope.mergeItem.id
        }).then(function () {
            toastr.success('Merging was a sucess!');
            $scope.init();
        })
    }
    $scope.init();
});

app.controller('MenuController', function ($scope, $http) {
    $scope.companyId = angular.element('#companyId').val();
    $scope.employeeId = angular.element('#employeeId').val();
    $scope.resetDemo = function(){
        $http.get('/api/company/resetdemo').then(function (r) {
            location.reload();
        });
    };
});

var closeSetUpWizard = null;
var closeHelp = null;
var closeWizard = null;
var openHelp = null;

$(document).ready(function () {
    $('#uploadBudgetForm')
        .ajaxForm({
            url: $('#uploadBudgetForm').attr('action'),
            dataType: 'json',
            success: function (response) {
                $('.modal').modal('hide');
                if (response.success) {
                    toastr.success('Budget Template Succesful Imported!');
                    angular.element('#targetProjectModal').scope().loadProject($('#uploadProjectId').val());
                } else {
                    toastr.error('Your file did not import for some reason. Please click <a style="color: #64b0f2" href="mailto:support@projectprohub.com?Subject=[Project%20Pro]%20Excel%20Upload%20Issues">support@projectprohub.com</a> to send us an email. Attach the file you attempted to upload with an explanation of what steps you took prior to the error.', 'Send us an email!', {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": 0,
                        "extendedTimeOut": 0,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        "tapToDismiss": false
                    });
                }
            }
        });

    $('#uploadCreditCardStatmentForm')
        .ajaxForm({
            url: $('#uploadCreditCardStatmentForm').attr('action'),
            dataType: 'json',
            success: function (response) {
                $('#ppro-loader').remove();
                if (response.success) {
                    toastr.success('Import Success!', 'Now its time to prepare how you would like to reconcile these data');
                    $('.modal').modal('hide');
                    if (response.hasDuplicates) {
                        $('#checkDuplciateTransactionsModal').modal('show');
                    } else {
                        $('#prepareReconcileModal').modal('show');
                    }
                } else {
                    toastr.error('Your file did not import for some reason. Please click <a style="color: #64b0f2" href="mailto:support@projectprohub.com?Subject=[Project%20Pro]%20Excel%20Upload%20Issues">support@projectprohub.com</a> to send us an email. Attach the file you attempted to upload with an explanation of what steps you took prior to the error.', 'Send us an email!', {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": 0,
                        "extendedTimeOut": 0,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        "tapToDismiss": false
                    });
                    $('.modal').modal('hide');
                }

            }
        });

    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

    closeSetUpWizard = function closeSetUpWizard() {
        $.post('/api/employees/' + applicationUserId + '/setDone', {
            type: 'wizard',
            companyId: $('#companyId').val()
        });
        $('.setup-wizard-container:eq(0)').hide("slide", {
            direction: "right"
        }, 1000, function () {
            $('.setup-wizard-container').hide();
            $('.setup-wizard-container').css('height', '');
            $('.setup-wizard-container').css('width', '');
            $('.setup-wizard-container').css('top', '');
            $('.setup-wizard-container').css('right', '');
            $('.setup-wizard-container').css('bottom', '');
            $('.setup-wizard-container').css('left', '');
            $('#congratulationsModal').modal('show');
        });
    };

    closeHelp = function closeHelp() {
        $('.page-help').hide("slide", {
            direction: "right"
        }, 1000, function () {
            $('.page-help').css('height', '');
            $('.page-help').css('width', '');
            $('.page-help').css('top', '');
            $('.page-help').css('right', '');
            $('.page-help').css('bottom', '');
            $('.page-help').css('left', '');
        });
    };

    closeWizard = function closeWizard() {
        $('.setup-wizard-container:eq(0)').hide("slide", {
            direction: "right"
        }, 1000, function () {
            $('.setup-wizard-container').css('height', '');
            $('.setup-wizard-container').css('width', '');
            $('.setup-wizard-container').css('top', '');
            $('.setup-wizard-container').css('right', '');
            $('.setup-wizard-container').css('bottom', '');
            $('.setup-wizard-container').css('left', '');
            $('.setup-wizard-container').css('display', 'none');
        });
    };

    openHelp = function () {
        $('.page-help').show("slide", {
            direction: "right"
        }, 1000);
    };

    $(".setup-wizard-container").draggable({
        handle: '.setup-wizard-header'
    });

    $(".resizable").resizable({
        handles: 'all'
    });
});