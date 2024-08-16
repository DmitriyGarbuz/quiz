<?php namespace App\Controllers\Controler;

use CodeIgniter\Controller;
use App\Models\CtUsers as CtUsersModel;
use App\Models\Config as ConfigModel;
use App\Models\Languages as LanguagesModel;
use App\Models\Chapters as ChaptersModel;
use App\Models\Articles as ArticlesModel;
use App\Models\Notes as NotesModel;
use App\Models\Categorys as CategorysModel;
use App\Models\Goods as GoodsModel;

class Base extends Controller
{
	
	protected $helpers = [];
	public $path = 'controler/';
	
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	
	function getList($actPage='',$inPage='')
	{
		
		$CtUsersModel = new CtUsersModel;
		$ConfigModel = new ConfigModel;
		$LanguagesModel = new LanguagesModel;
		
		return array (
			'confSet' => $ConfigModel->getConfSet(), 
			'confLang' => $LanguagesModel->getConfLang(), 
			'newEventsCount' => $ConfigModel->getNewEventsCount(), 
			'ctChapters' => $ConfigModel->getCtChapters(), 
			'languages' => $LanguagesModel->orderBy('main DESC, number ASC')->find(),
			'ctUser' => $CtUsersModel->where('ctUserId',session('ctUserId'))->first(),
			'actPage' => $actPage,		
			'inPage' => $inPage,
		);
		
	}
	
	function controlTest ($ctChapter='') {
	
		$CtUsersModel = new CtUsersModel;
		
		if ($ctChapter=='') {
			if ((session('controlLogin')=='myControl')OR(session('controlLogin')=='control')) { redirect ($this->path.'home'); } 
		} else {
			if (session('controlLogin')=='myControl') {
				return TRUE;
			} else {
				if (session('controlLogin')=='control') { 
					if (!$CtUsersModel->testCtUserLogin($ctChapter)) { return FALSE; } else { return TRUE; }
				} else {
					redirect ('/control');
				}
			}
		}
		
	}	
	
	function getNewEventsCount() { 
		$ConfigModel = new ConfigModel;
		echo $ConfigModel->getNewEventsCount(); 
	}
	
	function sitemap () {
		
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		$file = fopen('sitemap.xml', 'w');
		
		$string = '<?xml version="1.0" encoding="UTF-8"?>'; fwrite($file, $string."\r\n"); 
		$string = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; fwrite($file, $string."\r\n"); 

		$chaptersLastMod = $this->sitemapChapters();
		$string = '<sitemap>'; fwrite($file, $string."\r\n"); 
		$string = '<loc>'.base_url().'sitemap_chapters.xml</loc>'; fwrite($file, $string."\r\n"); 
		$string = '</sitemap>'; fwrite($file, $string."\r\n"); 
		
		$articlesLastMod = $this->sitemapArticles();
		$string = '<sitemap>'; fwrite($file, $string."\r\n"); 
		$string = '<loc>'.base_url().'sitemap_articles.xml</loc>'; fwrite($file, $string."\r\n"); 
		$string = '</sitemap>'; fwrite($file, $string."\r\n"); 
		
		$notesLastMod = $this->sitemapNotes();
		$string = '<sitemap>'; fwrite($file, $string."\r\n"); 
		$string = '<loc>'.base_url().'sitemap_notes.xml</loc>'; fwrite($file, $string."\r\n"); 
		$string = '</sitemap>'; fwrite($file, $string."\r\n"); 
		
		$string = '</sitemapindex>'; fwrite($file, $string."\r\n"); 
		
	}
	
	function sitemapChapters() {
		
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		$file = fopen('sitemap_chapters.xml', 'w');
		
		$string = '<?xml version="1.0" encoding="UTF-8"?>'; fwrite($file, $string."\r\n"); 
		$string = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; fwrite($file, $string."\r\n"); 
		
		$ChaptersModel = new ChaptersModel;
		$LanguagesModel = new LanguagesModel;
		$chapters = $ChaptersModel->orderBy('number','asc')->orderBy('parent','asc')->where('sitemap',1)->find();
		$languages = $LanguagesModel->where('visible',1)->find();
	
		$i=0;
		foreach ($chapters as $one) {
			$string = '<url>'; fwrite($file, $string."\r\n"); 
			if ($i==0) {
				$string = '<loc>'.base_url().'</loc>'; fwrite($file, $string."\r\n"); 
				$string = '<priority>1</priority>'; fwrite($file, $string."\r\n"); 
			} else {
				$string = '<loc>'.base_url().$one['url'].'</loc>'; fwrite($file, $string."\r\n"); 
				$string = '<priority>'.$one['priority'].'</priority>'; fwrite($file, $string."\r\n"); 
			}
			if ($one['lastmod']!='') {
				$string = '<lastmod>'.$one['lastmod'].'</lastmod>'; fwrite($file, $string."\r\n"); 
			}
			$string = '<changefreq>'.$one['changefreq'].'</changefreq>'; fwrite($file, $string."\r\n"); 
			$string = '</url>'; fwrite($file, $string."\r\n"); 
			foreach ($languages as $two) { if ($two['url']!='') {
				$string = '<url>'; fwrite($file, $string."\r\n"); 
				$string	= '<loc>'.base_url().$two['url'].'/'.$one['url'].'</loc>'; fwrite($file, $string."\r\n"); 
				$string = '<priority>'.$one['priority'].'</priority>'; fwrite($file, $string."\r\n"); 
				if ($one['lastmod']!='') {
					$string = '<lastmod>'.$one['lastmod'].'</lastmod>'; fwrite($file, $string."\r\n"); 
				}
				$string = '<changefreq>'.$one['changefreq'].'</changefreq>'; fwrite($file, $string."\r\n"); 
				$string = '</url>'; fwrite($file, $string."\r\n"); 
			} }
			$i++;
		}
		
		$string = '</urlset>'; fwrite($file, $string."\r\n"); 

	}
	
	function sitemapNotes() {
		
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
		
		$file = fopen('sitemap_notes.xml', 'w');
		
		$string = '<?xml version="1.0" encoding="UTF-8"?>'; fwrite($file, $string."\r\n"); 
		$string = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; fwrite($file, $string."\r\n"); 
		
		$NotesModel = new NotesModel;
		$LanguagesModel = new LanguagesModel;
		$notes = $NotesModel->where('sitemap',1)->find();
		$languages = $LanguagesModel->where('visible',1)->find();
		
		$i=0;
		foreach ($notes as $one) {
			$string = '<url>'; fwrite($file, $string."\r\n"); 
			$string = '<loc>'.base_url().'note/'.$one['url'].'</loc>'; fwrite($file, $string."\r\n"); 
			if ($one['priority']!=0) {
				$string = '<priority>'.$one['priority'].'</priority>'; fwrite($file, $string."\r\n"); 
			}
			if ($one['lastmod']!='') {
				$string = '<lastmod>'.$one['lastmod'].'</lastmod>'; fwrite($file, $string."\r\n"); 
			}
			if ($one['changefreq']!='') {
				$string = '<changefreq>'.$one['changefreq'].'</changefreq>'; fwrite($file, $string."\r\n"); 
			}
			$string = '</url>'; fwrite($file, $string."\r\n"); 
			foreach ($languages as $two) { if ($two['url']!='') {
				$string = '<url>'; fwrite($file, $string."\r\n"); 
				$string	= '<loc>'.base_url().$two['url'].'/note/'.$one['url'].'</loc>'; fwrite($file, $string."\r\n"); 
				if ($one['priority']!=0) {
					$string = '<priority>'.$one['priority'].'</priority>'; fwrite($file, $string."\r\n"); 
				}
				if ($one['lastmod']!='') {
					$string = '<lastmod>'.$one['lastmod'].'</lastmod>'; fwrite($file, $string."\r\n"); 
				}
				if ($one['changefreq']!='') {
					$string = '<changefreq>'.$one['changefreq'].'</changefreq>'; fwrite($file, $string."\r\n"); 
				}
				$string = '</url>'; fwrite($file, $string."\r\n"); 
			} }
			$i++;
		}
		
		$string = '</urlset>'; fwrite($file, $string."\r\n"); 

	}
	
	function sitemapArticles() {
		
		set_time_limit(200000000000);
		ini_set("max_execution_time", "10000000000"); 
		ini_set('memory_limit','512M');
	
		$file = fopen('sitemap_articles.xml', 'w');
		
		$string = '<?xml version="1.0" encoding="UTF-8"?>'; fwrite($file, $string."\r\n"); 
		$string = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; fwrite($file, $string."\r\n"); 
		
		$ArticlesModel = new ArticlesModel;
		$LanguagesModel = new LanguagesModel;
		$articles = $ArticlesModel->where('sitemap',1)->find();
		$languages = $LanguagesModel->where('visible',1)->find();
		
		$i=0;
		foreach ($articles as $one) {
			$string = '<url>'; fwrite($file, $string."\r\n"); 
			$string = '<loc>'.base_url().'article/'.$one['url'].'</loc>'; fwrite($file, $string."\r\n"); 
			$string = '<priority>'.$one['priority'].'</priority>'; fwrite($file, $string."\r\n"); 
			if ($one['lastmod']!='') {
				$string = '<lastmod>'.$one['lastmod'].'</lastmod>'; fwrite($file, $string."\r\n"); 
			}
			$string = '<changefreq>'.$one['changefreq'].'</changefreq>'; fwrite($file, $string."\r\n"); 
			$string = '</url>'; fwrite($file, $string."\r\n"); 
			foreach ($languages as $two) { if ($two['url']!='') {
				$string = '<url>'; fwrite($file, $string."\r\n"); 
				$string	= '<loc>'.base_url().$two['url'].'/article/'.$one['url'].'</loc>'; fwrite($file, $string."\r\n"); 
				$string = '<priority>'.$one['priority'].'</priority>'; fwrite($file, $string."\r\n"); 
				if ($one['lastmod']!='') {
					$string = '<lastmod>'.$one['lastmod'].'</lastmod>'; fwrite($file, $string."\r\n"); 
				}
				$string = '<changefreq>'.$one['changefreq'].'</changefreq>'; fwrite($file, $string."\r\n"); 
				$string = '</url>'; fwrite($file, $string."\r\n"); 
			} }
		}
		$i++;
		
		$string = '</urlset>'; fwrite($file, $string."\r\n"); 
	
	}

}
