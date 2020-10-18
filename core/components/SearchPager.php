<?php
/**
 * 
 * @author Nam Long Software
 *
 */
class SearchPager extends CLinkPager
{
	/**
	 * @var string the CSS class for the selected page buttons. Defaults to 'selected'.
	 * @since 1.1.11
	 */
	public $selectedPageCssClass='active';
	/**
	 * @var string the CSS class for the previous page button. Defaults to 'previous'.
	 * @since 1.1.11
	 */
	public $previousPageCssClass=parent::CSS_PREVIOUS_PAGE;
	/**
	 * @var string the CSS class for the next page button. Defaults to 'next'.
	 * @since 1.1.11
	 */
	public $nextPageCssClass=parent::CSS_NEXT_PAGE;
	/**
	 * @var string the CSS class for the internal page buttons. Defaults to 'page'.
	 * @since 1.1.11
	 */
	public $internalPageCssClass=self::CSS_INTERNAL_PAGE;
	/**
	 * @var string the CSS class for the hidden page buttons. Defaults to 'hidden'.
	 * @since 1.1.11
	 */
	public $hiddenPageCssClass='disabled';
	
	/**
	 * @var string name of the GET variable storing the current page index. Defaults to 'page'.
	 */
	public $pageVar='page';
	/**
	 * @var string the route (controller ID and action ID) for displaying the paged contents.
	 * Defaults to empty string, meaning using the current route.
	 */
	public $route='';
	/**
	 * @var array of parameters (name=>value) that should be used instead of GET when generating pagination URLs.
	 * Defaults to null, meaning using the currently available GET parameters.
	 */
	public $params;
	
	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','Next &gt;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt; Previous');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&lt;&lt; First');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','Last &gt;&gt;');
		if($this->header===null)
			$this->header=Yii::t('yii','Go to page: ');
	
		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='';
	}
	
	
	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();
	
		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();
		
		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);
	
		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
		
		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);
	
	
	
		return $buttons;
	}
	
	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
	}
	
	/**
	 * Creates the URL suitable for pagination.
	 * @param integer $page the page that the URL should point to.
	 * @return string the created URL
	 * @see CPagination::createPageUrl
	 */
	protected function createPageUrl($page)
	{
		$params=$this->params===null ? $_GET : $this->params;
		$params[$this->pageVar]=$page+1;
		
		return url('/search/result',$params);
	}
}