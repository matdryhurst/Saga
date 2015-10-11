<?php defined('BASEPATH') || exit('No direct script access allowed');

//------------------------------------------------------------------------------
// !Smart Embed Paths
//------------------------------------------------------------------------------
$config['smartembed_template_location'] = APPPATH. 'modules/embedcontent/templates/';
$config['smartembed_static_site_location'] = FCPATH.'static/';

//------------------------------------------------------------------------------
// !Upload settings
//------------------------------------------------------------------------------
$config['upload_path'] = $config['smartembed_template_location'];
$config['allowed_types'] = 'zip';
$config['max_size']	= '1000000000';