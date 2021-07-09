<?php

if ( !class_exists('Puc_v4p8_Autoloader', false) ):

	class Puc_v4p8_Autoloader {
		private $prefix = '';
		private $rootDir = '';
		private $libraryDir = '';

		private $staticMap;

		public function __construct() {
			$this->rootDir = dirname(__FILE__) . '/';
			$nameParts = explode('_', __CLASS__, 3);
			$this->prefix = $nameParts[0] . '_' . $nameParts[1] . '_';

			$this->libraryDir = realpath($this->rootDir . '../..') . '/';
			$this->staticMap = array(
				'PucReadmeParser' => 'vendor/PucReadmeParser.php',
				'Parsedown' => 'vendor/Parsedown.php',
				'Puc_v4_Factory' => 'Puc/v4/Factory.php',
			);

			spl_autoload_register(array($this, 'autoload'));
		}

		public function autoload($className) {
			global $wp_filesystem;
            if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
               wp_filesystem($creds);
            }
			if ( isset($this->staticMap[$className]) && $wp_filesystem->exists($this->libraryDir . $this->staticMap[$className]) ) {
				/** @noinspection PhpIncludeInspection */
				include ($this->libraryDir . $this->staticMap[$className]);
				return;
			}

			if (strpos($className, $this->prefix) === 0) {
				$path = substr($className, strlen($this->prefix));
				$path = str_replace('_', '/', $path);
				$path = $this->rootDir . $path . '.php';

				if ($wp_filesystem->exists($path)) {
					/** @noinspection PhpIncludeInspection */
					include $path;
				}
			}
		}
	}

endif;
