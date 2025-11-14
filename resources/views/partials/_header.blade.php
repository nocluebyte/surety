<!-- begin::Header-->
<style type="text/css">
    @media (min-width: 992px) {
        .header-menu .menu-nav>.menu-item .menu-submenu>.menu-subnav .menu-content .menu-heading>.menu-text {
            font-size: 1.20rem !important;
        }
    }
</style>

@php
    $sales = ['users.superadmin','proposals.list', 'bid_bond.list','performance_bond.list', 'advance_payment_bond.list', 'retention_bond.list', 'maintenance_bond.list','bondPoliciesIssueChecklist'];
    $functions = ['users.superadmin', 'principle.list', 'beneficiary.list', 'tender.list', 'group.list', 'adverse_information.list', 'blacklist.list', 'project-details.list'];
    $cases = ['users.superadmin','cases.list'];
    $teams = ['users.superadmin', 'agent.list', 'broker.list', 'underwriter.list', 'employee.list', 'relationship_manager.list', 'claim_examiner.list'];
    $bonds = ['users.superadmin', 'bond_policies_issue.list'];
    $finance = ['users.superadmin', 'premium.list'];
    $invocation = ['users.superadmin','invocation_notification.list'];
@endphp
<div id="kt_header" class="header header-fixed">
    <!--begin::Header Wrapper-->
    <div class="header-wrapper rounded-top-xl d-flex flex-grow-1 align-items-center">
        <!--begin::Container-->
        <div class="container-fluid d-flex align-items-center justify-content-end justify-content-lg-between flex-wrap">
            <!--begin::Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left py-lg-2" id="kt_header_menu_wrapper">
                <!--begin::Menu-->
                <div id="kt_header_menu"
                    class="header-menu header-menu-mobile header-menu-layout-default header-menu-root-arrow">
                    <!--begin::Nav-->
                    <ul class="menu-nav">
                      
                        @if ($current_user->hasAnyAccess($sales))
                            <li class="menu-item menu-item-submenu menu-item-rel {{ isActive(['proposals.*', 'bond.*', 'bid-bond.*', 'performance-bond.*','bondPoliciesIssueChecklist','bondInvocationNotification', 'advance-payment-bond.*', 'retention-bond.*','maintenance-bond.*', 'bond-nbi.*', 'nbi.*', 'bond_policies_issue.create', 'bond-progress.*', 'bondClosureCreate', 'bondCancelCreate','tender-evaluation', 'createBondForeClosure', 'createBondCancellation'], 'menu-item-here') }}"
                                data-menu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">{{ __('header.sales') }}</span>
                                    <span class="menu-desc"></span>
                                    <!-- <i class="menu-arrow"></i> -->
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                         @if ($current_user->hasAnyAccess(['proposals.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('proposals.*', 'nbi.*','tender-evaluation','bondPoliciesIssueChecklist','bond-progress.*', 'createBondForeClosure', 'createBondCancellation', 'bond_policies_issue.create') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('proposals.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.proposals') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- @if ($current_user->hasAnyAccess(['bid_bond.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('bid-bond.*') || (request()->segment(1) == 'bond_policies_issue' && request()->get('bond_type') == 'BidBond') || (request()->segment(1) == 'bond-policies-issue-checklist' && request()->get('bond_type') == 'bid_bond') || (request()->segment(1) == 'bond-invocation-notification' && request()->get('bond_type') == 'bid_bond') || (request()->segment(1) == 'bond-nbi' && request()->get('bond_type') == 'bid_bond') || (request()->segment(1) == 'bond-progress' && request()->get('bond_type') == 'BidBond') || (request()->segment(1) == 'bond-closure' && request()->get('bond_type') == 'BidBond') || (request()->segment(1) == 'bond-cancel' && request()->get('bond_type') == 'BidBond') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('bid-bond.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.bid_bond') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                         @if ($current_user->hasAnyAccess(['performance_bond.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('performance-bond.*') || (request()->segment(1) == 'bond_policies_issue' && request()->get('bond_type') == 'PerformanceBond') || (request()->segment(1) == 'bond-policies-issue-checklist' && request()->get('bond_type') == 'performance_bond') || (request()->segment(1) == 'bond-nbi' && request()->get('bond_type') == 'performance_bond') || (request()->segment(1) == 'bond-progress' && request()->get('bond_type') == 'PerformanceBond') || (request()->segment(1) == 'bond-closure' && request()->get('bond_type') == 'PerformanceBond') || (request()->segment(1) == 'bond-cancel' && request()->get('bond_type') == 'PerformanceBond') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('performance-bond.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.performance_bond') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['advance_payment_bond.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('advance-payment-bond.*') || (request()->segment(1) == 'bond_policies_issue' && request()->get('bond_type') == 'AdvancePaymentBond') || (request()->segment(1) == 'bond-policies-issue-checklist' && request()->get('bond_type') == 'advance_payment_bond') || (request()->segment(1) == 'bond-nbi' && request()->get('bond_type') == 'advance_payment_bond') || (request()->segment(1) == 'bond-progress' && request()->get('bond_type') == 'AdvancePaymentBond') || (request()->segment(1) == 'bond-closure' && request()->get('bond_type') == 'AdvancePaymentBond') || (request()->segment(1) == 'bond-cancel' && request()->get('bond_type') == 'AdvancePaymentBond') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('advance-payment-bond.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.advance_payment_bond') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['retention_bond.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('retention-bond.*') || (request()->segment(1) == 'bond_policies_issue' && request()->get('bond_type') == 'RetentionBond') || (request()->segment(1) == 'bond-policies-issue-checklist' && request()->get('bond_type') == 'retention_bond') || (request()->segment(1) == 'bond-nbi' && request()->get('bond_type') == 'retention_bond') || (request()->segment(1) == 'bond-progress' && request()->get('bond_type') == 'RetentionBond') || (request()->segment(1) == 'bond-closure' && request()->get('bond_type') == 'RetentionBond') || (request()->segment(1) == 'bond-cancel' && request()->get('bond_type') == 'RetentionBond') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('retention-bond.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.retention_bond') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['maintenance_bond.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('maintenance-bond.*') || (request()->segment(1) == 'bond_policies_issue' && request()->get('bond_type') == 'MaintenanceBond') || (request()->segment(1) == 'bond-policies-issue-checklist' && request()->get('bond_type') == 'maintenance_bond') || (request()->segment(1) == 'bond-nbi' && request()->get('bond_type') == 'maintenance_bond') || (request()->segment(1) == 'bond-progress' && request()->get('bond_type') == 'MaintenanceBond') || (request()->segment(1) == 'bond-closure' && request()->get('bond_type') == 'MaintenanceBond') || (request()->segment(1) == 'bond-cancel' && request()->get('bond_type') == 'MaintenanceBond') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('maintenance-bond.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.maintenance_bond') }}</span>
                                                </a>
                                            </li>
                                        @endif --}}
                                    </ul>
                                </div>
                                
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess($functions))
                            <li class="menu-item menu-item-submenu menu-item-rel {{ isActive(['principle.*', 'beneficiary.*', 'tender.*', 'group.*', 'adverse-information.*', 'blacklist.*', 'project-details.*', 'tender_import', 'beneficiary_import', 'principle_import'], 'menu-item-here') }}"
                                data-menu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">{{ __('header.functions') }}</span>
                                    <span class="menu-desc"></span>
                                    <!-- <i class="menu-arrow"></i> -->
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        @if ($current_user->hasAnyAccess(['principle.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('principle.*', 'principle_import') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('principle.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.principle') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['beneficiary.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('beneficiary.*', 'beneficiary_import') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('beneficiary.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.beneficiary') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['project-details.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('project-details.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('project-details.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.project_details') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['tender.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('tender.*', 'tender_import') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('tender.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.tender') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['group.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('group.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('group.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.group') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['adverse_information.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('adverse-information.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('adverse-information.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.adverse_information') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['blacklist.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('blacklist.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('blacklist.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.blacklist') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess($cases))
                            <li class="menu-item {{ Route::currentRouteNamed('cases.*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
                                <a href="{{route('cases.index')}}" class="menu-link">
                                    <span class="menu-text">{{__('header.cases')}}</span>
                                    <span class="menu-desc"></span>
                                </a>
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess($teams))
                            <li class="menu-item menu-item-submenu menu-item-rel {{ isActive(['agent.*', 'broker.*', 'underwriter.*', 'employee.*', 'relationship_manager.*', 'claim-examiner.*'], 'menu-item-here') }}"
                                data-menu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">{{ __('header.teams') }}</span>
                                    <span class="menu-desc"></span>
                                    <!-- <i class="menu-arrow"></i> -->
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        @if ($current_user->hasAnyAccess(['agent.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('agent.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('agent.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.agent') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['broker.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('broker.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('broker.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.broker') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['underwriter.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('underwriter.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('underwriter.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.underwriter') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['claim_examiner.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('claim-examiner.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('claim-examiner.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.claim_examiner') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['employee.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('employee.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('employee.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.employee') }}</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if ($current_user->hasAnyAccess(['relationship_manager.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('relationship_manager.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('relationship_manager.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.relationship_manager') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess($bonds))
                            <li class="menu-item {{ Route::currentRouteNamed('bond_policies_issue.index', 'bond_policies_issue.show') ? 'menu-item-active' : '' }}"
                            aria-haspopup="true">
                                <a href="{{ route('bond_policies_issue.index') }}" class="menu-link">
                                    <span class="menu-text">{{ __('header.bonds') }}</span>
                                </a>
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess($finance))
                            <li class="menu-item menu-item-submenu menu-item-rel {{ isActive(['premium.*', 'collection.*'], 'menu-item-here') }}"
                                data-menu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">{{ __('header.finance') }}</span>
                                    <span class="menu-desc"></span>
                                    <!-- <i class="menu-arrow"></i> -->
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        @if ($current_user->hasAnyAccess(['premium.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('premium.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('premium.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.premium') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess($invocation))
                            <li class="menu-item menu-item-submenu menu-item-rel {{ isActive(['invocation-notification.*'], 'menu-item-here') }}"
                                data-menu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">{{ __('header.invocation') }}</span>
                                    <span class="menu-desc"></span>
                                    <!-- <i class="menu-arrow"></i> -->
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        @if ($current_user->hasAnyAccess(['invocation_notification.list', 'users.superadmin']))
                                            <li class="menu-item {{ Route::currentRouteNamed('invocation-notification.*') ? 'menu-item-active' : '' }}"
                                                aria-haspopup="true">
                                                <a href="{{ route('invocation-notification.index') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">

                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path
                                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                                                    x="16.3255682" y="2.94551858" width="3"
                                                                    height="18" rx="1" />
                                                            </g>
                                                        </svg>

                                                    </span>
                                                    <span class="menu-text">{{ __('header.invocation_notification') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                       
                                    </ul>
                                </div>
                            </li>
                        @endif

                        @if ($current_user->hasAnyAccess(['recovery.list', 'users.superadmin']))
                            <li class="menu-item {{ Route::currentRouteNamed('recovery.*') ? 'menu-item-active' : '' }}"
                                aria-haspopup="true">
                                <a href="{{ route('recovery.index') }}" class="menu-link">
                                    <span class="menu-text">{{ __('header.recovery') }}</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>

            {{-- <div class="d-flex align-items-center py-3">
                <div class="dropdown dropdown-inline" title="" data-placement="left">



                </div>

                <div class="dropdown dropdown-inline" title="" data-placement="left">
                    <a href="#" class="btn btn-sm btn-light-info ml-3 flex-shrink-0" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="icon-sm far fa-calendar-alt"></span>&nbsp;&nbsp;
                        {{ Session::get('default_year_name') }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right p-0" style="">
                        <ul class="navi navi-hover py-5">
                            @php
                                $default_year = Session::get('default_year');
                            @endphp

                            @if (isset($header_year) && $header_year->count() > 0)
                                @foreach ($header_year as $y)
                                    @if ($y->is_displayed == 'Yes')
                                        <li class="navi-item">
                                            <a href="{{ route('years.changeYear', [$y->id, '_url' => Request::getRequestUri()]) }}"
                                                class="navi-link {{ isset($default_year) && $y->id == $default_year->id ? 'active' : '' }}">
                                                <span class="font-weight-bolder text-dark-50 pr-3">
                                                    FY
                                                </span>
                                                <span class="navi-text">{{ $y->yearname ?? '' }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
