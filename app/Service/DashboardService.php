<?php 

namespace App\Service;
use Sentinel;

class DashboardService 
{
    public function getCurrentUser(){
        $current_user = Sentinel::getUser();
      
        return $current_user ?? null;
    }

    public function getCurrentUserRole(){

        $current_user = $this->getCurrentUser();

        $role = $current_user?->roles?->first()?->slug ?? '';

        return $role;

    }
    public function getDashboard(){
        
        $role = $this->getCurrentUserRole();
       
        $dashboard = '';
        switch ($role) {

            case 'administrator':
                $dashboard = 'dashboard.superadmin';
                break;

            case 'contractor':
                $dashboard = 'dashboard.contractor';
                break;

            case 'commercial-underwriter':
            case 'risk-underwriter':    
                $dashboard = 'dashboard.underwriter';
                break;

            case 'claim-examiner':    
                $dashboard = 'dashboard.claim-examiner';
                break;
            
            case 'beneficiary':    
                $dashboard = 'dashboard.beneficiary';
                break;
            
            default:
                $dashboard = 'dashboard.general';
                break;
        }

        return $dashboard;
    } 
}

