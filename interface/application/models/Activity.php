<?php
class Activity extends CI_Model
{
    
	private $table_name='activity_log';
	private static $db;

    function __construct(){
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    static function get_activity_data($module_name,$apidata){
        $data=array();

        $module_name=strtolower($module_name);

        switch ($module_name) {

        //organization        
        case 'organization_update':
            $data['description']='updated the details of an organization - '.$apidata['name'];
        break;

        
        //organization branches
        case 'organization_branches_create':
            $data['description']='created a new branch '.$apidata['name'].' of an organization '.$apidata['organization_name'];
        break;
        
        case 'organization_branches_update':
            $data['description']='updated the branch '.$apidata['name'].' of an organization '.$apidata['organization_name'];
        break;

        case 'organization_branches_delete':
            $data['description']='deleted the branch '.$apidata['name'].' of an organization '.$apidata['organization_name'];
        break;


        //department
        case 'department_create':
            $data['description']='created a new department '.$apidata['name'].' ';
            if($apidata['parent_name']){
                $data['description'].='under '.$apidata['parent_name'].' ';
            }
            $data['description'].='for the organization branch '.$apidata['organization_branches_name'];
        break;
        
        case 'department_update':
            $data['description']='updated the department '.$apidata['name'].' ';
            if($apidata['parent_name']){
                $data['description'].='which is under '.$apidata['parent_name'].' ';
            }
            $data['description'].='of an organization branch '.$apidata['organization_branches_name'];
        break;

        case 'department_delete':
            $data['description']='deleted the department '.$apidata['name'].' ';
            if($apidata['parent_name']){
                $data['description'].='which is under '.$apidata['parent_name'].' ';
            }
            $data['description'].='of an organization branch '.$apidata['organization_branches_name'];
        break;


        //users
        case 'users_create':
            $data['description']='created a new user '.$apidata['login_id'].' ('.$apidata['first_name'].' '.$apidata['last_name'].') ';
            if($apidata['roles_name']){
                $data['description'].='with a role '.$apidata['roles_name'].' ';
            }
            if($apidata['departments_name']){
                $data['description'].='and allocated to '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;

        case 'users_update':
            $data['description']='updated the user '.$apidata['login_id'].' ('.$apidata['first_name'].' '.$apidata['last_name'].') ';
            if($apidata['roles_name']){
                $data['description'].='with '.$apidata['roles_name'].' role ';
            }
            if($apidata['departments_name']){
                $data['description'].='and allocated to '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;

        case 'users_delete':
            $data['description']='deleted the user '.$apidata['login_id'].' ('.$apidata['first_name'].' '.$apidata['last_name'].') ';
            if($apidata['roles_name']){
                $data['description'].='with '.$apidata['roles_name'].' role ';
            }
            if($apidata['departments_name']){
                $data['description'].='and allocated to '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;

        //roles
        case 'roles_create':
            $data['description']='created a new role '.$apidata['name'];
            if($apidata['departments_name']){
                $data['description'].=' for '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;

        case 'roles_update':
            $data['description']='updated the role '.$apidata['name'];
            if($apidata['departments_name']){
                $data['description'].=' of '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;  

        case 'roles_delete':
            $data['description']='deleted the role '.$apidata['name'];
            if($apidata['departments_name']){
                $data['description'].=' of '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;

        case 'roles_permission_update':
            $data['description']='updated the permissions of a role '.$apidata['name'];
            if($apidata['departments_name']){
                $data['description'].=' of '.$apidata['departments_name'].' department ';
            }
            if($apidata['organization_branches_name']){
                $data['description'].='under '.$apidata['organization_branches_name'].' branch';
            }
        break;                
        
        
        //modules
        case 'modules_create':
            $data['description']='created a new module '.$apidata['name'];
        break;
        
        case 'modules_update':
            $data['description']='updated the module '.$apidata['name'];
        break;

        case 'modules_delete':
            $data['description']='deleted the module '.$apidata['name'];
        break;  

        
        //module permissions
        case 'module_permissions_create':
            $data['description']='created a new permission '.$apidata['name'].' for '.$apidata['modules_name'].' module';
        break;
        
        case 'module_permissions_update':
            $data['description']='updated the permission '.$apidata['name'].' belongs to '.$apidata['modules_name'].' module';
        break;

        case 'module_permissions_delete':
            $data['description']='deleted the permission '.$apidata['name'].' belongs to '.$apidata['modules_name'].' module';
        break;                

        
        //service categories
        case 'categories_create':
            $data['description']='created a new service category '.$apidata['name'];
        break;
        
        case 'categories_update':
            $data['description']='updated the service category '.$apidata['name'];
        break;

        case 'categories_delete':
            $data['description']='deleted the service category '.$apidata['name'];
        break;  


        //form_builder
        case 'formbuilder_create':
            $data['description']='created a new Form Template';
        break;
        
        case 'formbuilder_update':
            $data['description']='updated the Form Template '.$apidata['name'];
        break;

        case 'formbuilder_delete':
            $data['description']='deleted the Form Template '.$apidata['name'];
        break;

        //campaigns
        case 'campaigns_create':
            $data['description'] = 'Created a new Campaign - '.$apidata['name'];
            break;
        case 'campaigns_update':
            $data['description'] = 'Updated a Campaign - '.$apidata['name'];
            break;
        case 'campaigns_delete':
            $data['description'] = 'Deleted a Campaign - '.$apidata['name'];
            break;

        //form_categories
        case 'form_categories_create':
            $data['description'] = 'Created a new Form Category - '.$apidata['name'];
            break;
        case 'form_categories_update':
            $data['description'] = 'Updated a Form Category - '.$apidata['name'];
            break;
        case 'form_categories_delete':
            $data['description'] = 'Deleted a Form Category - '.$apidata['name'];
            break;

        //Responses
        case 'responses_create':
            $data['description'] = 'Created the new Response - '.$apidata['candidate_id'];
            break;
        case 'responses_update':
            $data['description'] = 'Updated a Response - '.$apidata['candidate_id'];
            break;
        case 'responses_delete':
            $data['description'] = 'Deleted a Response - '.$apidata['candidate_id'];
            break;


        default:
            $data=array(
                'action'=>'undefined',
                'module'=>'undefined',
                'data_id'=>'undefined',
                'description'=>'undefined'
            );
        break;
        }

        if(!empty($apidata)){
            $data['data_id']=$apidata['id'];
            preg_match_all('/(.*)_(.*)/s', $module_name, $matches);
            $count= count($matches);
            if($count>0){
                $data['action']=$matches[$count-1][0];
                $data['module']=$matches[$count-2][0];
            }
        }
        return $data;
    }

    static function module_log($module,$usertype,$apidata)
    {
        $usertype=ucfirst(strtolower($usertype)); 
        $data=Activity::get_activity_data($module,$apidata);
        $data['ip_address']=get_ipaddress();        
        $data['reference_id']=$usertype::get_userId();
        $data['reference_name']=$usertype::get_userName();
        $data['reference_type']=$usertype::get_ReferType();
        $ci =& get_instance();
        $apidata=$ci->curl->execute('activity_log',"POST",$data);
    }    
	
	
    
}
