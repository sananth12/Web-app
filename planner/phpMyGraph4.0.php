<?php
/**
* @Name: phpMyGraph4.0.php
* @Version: 4.0.2
* @License: No License - Free to use / modify
* @Date: 13-06-2008
* @Url: http://phpmygraph.abisvmm.nl
*/

/**
* @Usage:
* ----------------------------------------------------------------
*		//Include phpMyGraph class 
*		include_once('phpMyGraph4.0.php');
*		
*		//Create data array for graph
*		$data = array
*		(
*			'Mon'=>10,
*			'Tue'=>20,
*			'Wed'=>30,
*			'Thu'=>100,
*			'Fri'=>20,
*			'Sat'=>10,
*			'Sun'=>50,
*		);
*		
*		//Create new graph 
*		$graph = new phpMyGraph();
*		
*		//Parse vertical line graph
*		$graph->parseVerticalColumnGraph($data);
*
* ----------------------------------------------------------------
*/

class phpMyGraph
{

	/* Properties */
	
	/**
	 * @Name: ip
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Access: private
	 * @Since: version 10.00001
	 * @Comment: Image pointer
	*/
	private $ip;				

//--------------------------------------------------------------------------------

	/**
	 * @Name: __construct
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: void
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Constructor
	*/
	public function __construct()
	{
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseVerticalColumnGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses a vertical column graph
	*/
	public function parseVerticalColumnGraph($data,$cfg=array())
	{
		//Var
		$file = NULL;
		
		try
		{
			//Validate cfg & data arrays
			$cfg = $this->validate($cfg,$data);
			$dimensions = $this->calculateVerticalColumnGraph($cfg,$data);
			
			//Test file
			if(!empty($cfg['file-name']))
				$file = $cfg['file-name'];
			
			//Create imgage
			$this->createImage($cfg['width'],$cfg['height']);
			
			//Create colors
			$colors = $this->getColors($cfg);
			
			//Test transparent background
			if($cfg['transparent-background']>0)
				imagecolortransparent($this->ip,$colors['background-color']);
			
			//Draw default blocks
			$this->drawBackground($colors['background-color'],$dimensions);
			$this->drawGraphBackground($colors['graph-background-color'],$dimensions);
			$this->drawGraphBorder($colors['border-color'],$dimensions);

			//Var
			$columnIndex = 0;

			foreach($dimensions['columns'] as $columnData)
			{
				//Test allocateRandomColors
				if($cfg['random-column-color'])
				{
					$randomColors = $this->allocateRandomColors();
					$colors['column-color'] = $randomColors['forecolor'];
					$colors['column-shadow-color'] = $randomColors['backcolor'];
				}
					//Add
					//imagerectangle($this->ip,$columnData['rectangle']['x1'],$columnData['rectangle']['y1'],$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['border-color']);
					imagefilledrectangle($this->ip,$columnData['shadowRectangle']['x1'],$columnData['shadowRectangle']['y1'],$columnData['shadowRectangle']['x2'],$columnData['shadowRectangle']['y2'],$colors['column-shadow-color']);
					imagefilledrectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-color']);
					imagerectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-shadow-color']);

					//Print value
					imagestringup($this->ip,$cfg['font-size'],$columnData['text-position']['x'],$columnData['text-position']['y'],$columnData['value'],$colors[$columnData['color']]);
					
					//Print legenda
					imagestringup($this->ip,$cfg['font-size'],$columnData['legenda-position']['x'],$columnData['legenda-position']['y'],$columnData['key'],$colors['font-color']);
					
			}
			
			//Draw 0 & null line
			imagestring($this->ip,$cfg['font-size'],8,$dimensions['nullY']-(imagefontheight($cfg['font-size'])/2),"0",$colors['font-color']);
			imageline($this->ip,$dimensions['leftOffset']-8,$dimensions['nullY'],($dimensions['leftOffset']+$dimensions['graphBlock']['width']+8),$dimensions['nullY'],$colors['border-color']);

			//Draw min
			if($cfg['min']<0)
				imagestring($this->ip,$cfg['font-size'],8,(($dimensions['topOffset']+$dimensions['graphBlock']['height'])-(imagefontheight($cfg['font-size'])/2)),$cfg['min'],$colors['font-color']);
		
			//Draw max
			imagestring($this->ip,$cfg['font-size'],8,($dimensions['topOffset']-(imagefontheight($cfg['font-size'])/2)),$cfg['max'],$colors['font-color']);

			//Draw title
			imagestring($this->ip,$cfg['font-size'],130,2,$cfg['title'],$colors['font-color']);

		}
		catch(Exception $ex)
		{
			$this->parseErrorImage($ex->getMessage());
		}
		
		$this->parse($file);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseHorizontalColumnGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses a horizontal column graph
	*/
	public function parseHorizontalColumnGraph($data,$cfg=array())
	{
		//Var
		$file = NULL;

		try
		{
			//Validate cfg & data arrays
			$cfg = $this->validate($cfg,$data);
			$dimensions = $this->calculateHorizontalColumnGraph($cfg,$data);
			
			//Test file
			if(!empty($cfg['file-name']))
				$file = $cfg['file-name'];

			//Create imgage
			$this->createImage($cfg['width'],$cfg['height']);
			
			//Create colors
			$colors = $this->getColors($cfg);
			
			//Test transparent background
			if($cfg['transparent-background']>0)
				imagecolortransparent($this->ip,$colors['background-color']);
			
			//Draw default blocks
			$this->drawBackground($colors['background-color'],$dimensions);
			$this->drawGraphBackground($colors['graph-background-color'],$dimensions);
			$this->drawGraphBorder($colors['border-color'],$dimensions);

			//Var
			$columnIndex = 0;

			foreach($dimensions['columns'] as $columnData)
			{
				//Test allocateRandomColors
				if($cfg['random-column-color'])
				{
					$randomColors = $this->allocateRandomColors();
					$colors['column-color'] = $randomColors['forecolor'];
					$colors['column-shadow-color'] = $randomColors['backcolor'];
				}
			
					//Add
					//imagerectangle($this->ip,$columnData['rectangle']['x1'],$columnData['rectangle']['y1'],$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['column-shadow-color']);
					imagefilledrectangle($this->ip,$columnData['shadowRectangle']['x1'],$columnData['shadowRectangle']['y1'],$columnData['shadowRectangle']['x2'],$columnData['shadowRectangle']['y2'],$colors['column-shadow-color']);
					imagefilledrectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-color']);
					imagerectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-shadow-color']);

					//Print value
					imagestring($this->ip,$cfg['font-size'],$columnData['text-position']['x'],$columnData['text-position']['y'],$columnData['value'],$colors[$columnData['color']]);
					
					//Print legenda
					imagestring($this->ip,$cfg['font-size'],$columnData['legenda-position']['x'],$columnData['legenda-position']['y'],$columnData['key'],$colors['font-color']);
					
			}
			
			//Draw 0 & null line
			imagestring($this->ip,$cfg['font-size'],$dimensions['nullX']-(imagefontwidth($cfg['font-size'])/2),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),"0",$colors['font-color']);
			imageline($this->ip,$dimensions['nullX'],$dimensions['topOffset']-8,$dimensions['nullX'],($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$colors['border-color']);

			//Draw min
			if($cfg['min']<0)
				imagestring($this->ip,$cfg['font-size'],$dimensions['leftOffset']-(imagefontheight($cfg['font-size'])/2),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$cfg['min'],$colors['font-color']);
		
			//Draw max
			imagestring($this->ip,$cfg['font-size'],(($dimensions['leftOffset']+$dimensions['graphBlock']['width'])-(imagefontwidth($cfg['font-size'])/2)),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$cfg['max'],$colors['font-color']);

			//Draw title
			imagestring($this->ip,$cfg['font-size'],8,2,$cfg['title'],$colors['font-color']);

		}
		catch(Exception $ex)
		{
			$this->parseErrorImage($ex->getMessage());
		}
		
		$this->parse($file);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseVerticalLineGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses a vertical line graph
	*/
	public function parseVerticalLineGraph($data,$cfg=array())
	{
		//Var
		$file = NULL;

		try
		{
			//Validate cfg & data arrays
			$cfg = $this->validate($cfg,$data);
			$dimensions = $this->calculateVerticalColumnGraph($cfg,$data);
			
			//Test file
			if(!empty($cfg['file-name']))
				$file = $cfg['file-name'];
		
			//Create imgage
			$this->createImage($cfg['width'],$cfg['height']);
			
			//Create colors
			$colors = $this->getColors($cfg);
			
			//Test transparent background
			if($cfg['transparent-background']>0)
				imagecolortransparent($this->ip,$colors['background-color']);
			
			//Draw default blocks
			$this->drawBackground($colors['background-color'],$dimensions);
			$this->drawGraphBackground($colors['graph-background-color'],$dimensions);
			$this->drawGraphBorder($colors['border-color'],$dimensions);

			//Var
			$columnIndex = 0;
			$prevX = $dimensions['leftOffset'];
			$prevY = $dimensions['nullY'];

			foreach($dimensions['columns'] as $columnData)
			{
				//Test allocateRandomColors
				if($cfg['random-column-color'])
				{
					$randomColors = $this->allocateRandomColors();
					$colors['column-color'] = $randomColors['forecolor'];
					$colors['column-shadow-color'] = $randomColors['backcolor'];
				}
					//Add
					//imagerectangle($this->ip,$columnData['rectangle']['x1'],$columnData['rectangle']['y1'],$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['border-color']);
					//imagefilledrectangle($this->ip,$columnData['shadowRectangle']['x1'],$columnData['shadowRectangle']['y1'],$columnData['shadowRectangle']['x2'],$columnData['shadowRectangle']['y2'],$colors['column-shadow-color']);
					//imagefilledrectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-color']);
					//imagerectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-shadow-color']);

					//Print value
					if($cfg['disable-legenda']<1)
						imagestringup($this->ip,$cfg['font-size'],$columnData['text-position']['x'],$dimensions['nullY']-4,$columnData['value'],$colors[$columnData['color']]);
					
					//Va
					if($columnData['value']>=0)
					{
						imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2']-($dimensions['colWidth']/2),$columnData['rectangle']['y1'],$colors['column-color']);
						//Re-map 
						$prevX = $columnData['rectangle']['x2']-($dimensions['colWidth']/2);
						$prevY = $columnData['rectangle']['y1'];

					}
					else
					{
						imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2']-($dimensions['colWidth']/2),$columnData['rectangle']['y2'],$colors['column-color']);				
						//Re-map 
						$prevX = $columnData['rectangle']['x2']-($dimensions['colWidth']/2);
						$prevY = $columnData['rectangle']['y2'];

					}
					
					//Print legenda
					if($cfg['disable-legenda']<1)
						imagestringup($this->ip,$cfg['font-size'],$columnData['legenda-position']['x'],$columnData['legenda-position']['y'],$columnData['key'],$colors['font-color']);
					
			}
			
			//Draw 0 & null line
			imagestring($this->ip,$cfg['font-size'],8,$dimensions['nullY']-(imagefontheight($cfg['font-size'])/2),"0",$colors['font-color']);
			imageline($this->ip,$dimensions['leftOffset']-8,$dimensions['nullY'],($dimensions['leftOffset']+$dimensions['graphBlock']['width']+8),$dimensions['nullY'],$colors['border-color']);

			//Draw min
			if($cfg['min']<0)
				imagestring($this->ip,$cfg['font-size'],8,(($dimensions['topOffset']+$dimensions['graphBlock']['height'])-(imagefontheight($cfg['font-size'])/2)),$cfg['min'],$colors['font-color']);
		
			//Draw max
			imagestring($this->ip,$cfg['font-size'],8,($dimensions['topOffset']-(imagefontheight($cfg['font-size'])/2)),$cfg['max'],$colors['font-color']);

			//Draw title
			imagestring($this->ip,$cfg['font-size'],8,2,$cfg['title'],$colors['font-color']);

		}
		catch(Exception $ex)
		{
			$this->parseErrorImage($ex->getMessage());
		}
		
		$this->parse($file);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseHorizontalLineGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses a horizontal line graph
	*/
	public function parseHorizontalLineGraph($data,$cfg=array())
	{
		//Var
		$file = NULL;

		try
		{
			//Validate cfg & data arrays
			$cfg = $this->validate($cfg,$data);
			$dimensions = $this->calculateHorizontalColumnGraph($cfg,$data);
			
			//Test file
			if(!empty($cfg['file-name']))
				$file = $cfg['file-name'];

			//Create imgage
			$this->createImage($cfg['width'],$cfg['height']);
			
			//Create colors
			$colors = $this->getColors($cfg);
			
			//Test transparent background
			if($cfg['transparent-background']>0)
				imagecolortransparent($this->ip,$colors['background-color']);
			
			//Draw default blocks
			$this->drawBackground($colors['background-color'],$dimensions);
			$this->drawGraphBackground($colors['graph-background-color'],$dimensions);
			$this->drawGraphBorder($colors['border-color'],$dimensions);

			//Var
			$columnIndex = 0;
			$prevX = $dimensions['nullX'];
			$prevY = $dimensions['topOffset'];

			foreach($dimensions['columns'] as $columnData)
			{
					//imagerectangle($this->ip,$columnData['rectangle']['x1'],$columnData['rectangle']['y1'],$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['column-shadow-color']);

				//Test allocateRandomColors
				if($cfg['random-column-color'])
				{
					$randomColors = $this->allocateRandomColors();
					$colors['column-color'] = $randomColors['forecolor'];
					$colors['column-shadow-color'] = $randomColors['backcolor'];
				}
			
					//Print value
					if($columnData['value']>=0)
					{
						imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2'],$columnData['rectangle']['y2']-($dimensions['colHeight']/2),$colors['column-color']);
						//Re-map 
						$prevX = $columnData['rectangle']['x2'];
						$prevY = $columnData['rectangle']['y2']-($dimensions['colHeight']/2);

					}
					else
					{
						imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x1'],$columnData['rectangle']['y2']-($dimensions['colHeight']/2),$colors['column-color']);				
						//Re-map 
						$prevX = $columnData['rectangle']['x1'];
						$prevY = $columnData['rectangle']['y2']-($dimensions['colHeight']/2);

					}
					
					//Print value
					if($cfg['disable-values']<1)
						imagestring($this->ip,$cfg['font-size'],$dimensions['nullX']+4,$columnData['text-position']['y'],$columnData['value'],$colors[$columnData['color']]);
					
					//Print legenda
					if($cfg['disable-legenda']<1)
						imagestring($this->ip,$cfg['font-size'],$columnData['legenda-position']['x'],$columnData['legenda-position']['y'],$columnData['key'],$colors['font-color']);
					
			}
			
			//Draw 0 & null line
			imagestring($this->ip,$cfg['font-size'],$dimensions['nullX']-(imagefontwidth($cfg['font-size'])/2),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),"0",$colors['font-color']);
			imageline($this->ip,$dimensions['nullX'],$dimensions['topOffset']-8,$dimensions['nullX'],($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$colors['border-color']);

			//Draw min
			if($cfg['min']<0)
				imagestring($this->ip,$cfg['font-size'],$dimensions['leftOffset']-(imagefontheight($cfg['font-size'])/2),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$cfg['min'],$colors['font-color']);
		
			//Draw max
			imagestring($this->ip,$cfg['font-size'],(($dimensions['leftOffset']+$dimensions['graphBlock']['width'])-(imagefontwidth($cfg['font-size'])/2)),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$cfg['max'],$colors['font-color']);

			//Draw title
			imagestring($this->ip,$cfg['font-size'],8,2,$cfg['title'],$colors['font-color']);

		}
		catch(Exception $ex)
		{
			$this->parseErrorImage($ex->getMessage());
		}
		
		$this->parse($file);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseVerticalPolygonGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses a vertical line graph
	*/
	public function parseVerticalPolygonGraph($data,$cfg=array())
	{
		//Var
		$file = NULL;

		try
		{
			//Validate cfg & data arrays
			$cfg = $this->validate($cfg,$data);
			$dimensions = $this->calculateVerticalColumnGraph($cfg,$data);
			
			//Test file
			if(!empty($cfg['file-name']))
				$file = $cfg['file-name'];

			//Create imgage
			$this->createImage($cfg['width'],$cfg['height']);
			
			//Create colors
			$colors = $this->getColors($cfg);
			
			//Test transparent background
			if($cfg['transparent-background']>0)
				imagecolortransparent($this->ip,$colors['background-color']);
			
			//Draw default blocks
			$this->drawBackground($colors['background-color'],$dimensions);
			$this->drawGraphBackground($colors['graph-background-color'],$dimensions);
			$this->drawGraphBorder($colors['border-color'],$dimensions);

			//Var
			$columnIndex = 0;
			$prevX = $dimensions['leftOffset'];
			$prevY = $dimensions['nullY'];
			$prevValue = 0;

			foreach($dimensions['columns'] as $columnData)
			{
				//Test allocateRandomColors
				if($cfg['random-column-color'])
				{
					$randomColors = $this->allocateRandomColors();
					$colors['column-color'] = $randomColors['forecolor'];
					$colors['column-shadow-color'] = $randomColors['backcolor'];
				}
					//Add
					//imagerectangle($this->ip,$columnData['rectangle']['x1'],$columnData['rectangle']['y1'],$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['border-color']);
					//imagefilledrectangle($this->ip,$columnData['shadowRectangle']['x1'],$columnData['shadowRectangle']['y1'],$columnData['shadowRectangle']['x2'],$columnData['shadowRectangle']['y2'],$colors['column-shadow-color']);
					//imagefilledrectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-color']);
					//imagerectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-shadow-color']);
					
					
					//Print line
					if($columnData['value']>=0)
					{
						
						
						if($prevValue>=0)
						{
							$pol[0] = $prevX;
							$pol[1] = $prevY;
							$pol[2] = $columnData['rectangle']['x2'];
							$pol[3] = $columnData['rectangle']['y1'];
							$pol[4] = $pol[2];
							$pol[5] = $dimensions['nullY'];
							$pol[6] = $pol[0];
							$pol[7] = $dimensions['nullY'];
						}
						else
						{
							$pol[0] = $prevX;
							$pol[1] = $dimensions['nullY'];
							$pol[2] = $columnData['rectangle']['x2'];
							$pol[3] = $columnData['rectangle']['y1'];
							$pol[4] = $pol[2];
							$pol[5] = $dimensions['nullY'];
							$pol[6] = $pol[0];
							$pol[7] = $dimensions['nullY'];
						}						
						
						imagefilledpolygon($this->ip,$pol,4,$colors['column-color']);
						//imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2'],$columnData['rectangle']['y1'],$colors['column-shadow-color']);
						
						//Re-map 
						$prevX = $columnData['rectangle']['x2'];
						$prevY = $columnData['rectangle']['y1'];

					}
					else
					{
									
						
						
						if($prevValue<0)
						{
							$pol[0] = $prevX;
							$pol[1] = $dimensions['nullY'];
							$pol[2] = $columnData['rectangle']['x2'];
							$pol[3] = $dimensions['nullY'];
							$pol[4] = $pol[2];
							$pol[5] = $columnData['rectangle']['y2'];
							$pol[6] = $pol[0];
							$pol[7] = $prevY;
						}
						else
						{
							$pol[0] = $prevX;
							$pol[1] = $dimensions['nullY'];
							$pol[2] = $columnData['rectangle']['x2'];
							$pol[3] = $dimensions['nullY'];
							$pol[4] = $pol[2];
							$pol[5] = $columnData['rectangle']['y2'];
							$pol[6] = $pol[0];
							$pol[7] = $dimensions['nullY'];						
						}

						imagefilledpolygon($this->ip,$pol,4,$colors['column-color']);
						//imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['column-color']);	
						
						//Re-map 
						$prevX = $columnData['rectangle']['x2'];
						$prevY = $columnData['rectangle']['y2'];

					}

					//Map prev value
					$prevValue = $columnData['value'];

					//Print value
					if($cfg['disable-values']<1)
						imagestringup($this->ip,$cfg['font-size'],$columnData['text-position']['x'],$columnData['text-position']['y'],$columnData['value'],$colors[$columnData['color']]);
										
					//Print legenda
					if($cfg['disable-legenda']<1)
						imagestringup($this->ip,$cfg['font-size'],$columnData['legenda-position']['x'],$columnData['legenda-position']['y'],$columnData['key'],$colors['font-color']);
					
			}
			
			//Draw 0 & null line
			imagestring($this->ip,$cfg['font-size'],8,$dimensions['nullY']-(imagefontheight($cfg['font-size'])/2),"0",$colors['font-color']);
			imageline($this->ip,$dimensions['leftOffset']-8,$dimensions['nullY'],($dimensions['leftOffset']+$dimensions['graphBlock']['width']+8),$dimensions['nullY'],$colors['border-color']);

			//Draw min
			if($cfg['min']<0)
				imagestring($this->ip,$cfg['font-size'],8,(($dimensions['topOffset']+$dimensions['graphBlock']['height'])-(imagefontheight($cfg['font-size'])/2)),$cfg['min'],$colors['font-color']);
		
			//Draw max
			imagestring($this->ip,$cfg['font-size'],8,($dimensions['topOffset']-(imagefontheight($cfg['font-size'])/2)),$cfg['max'],$colors['font-color']);

			//Draw title
			imagestring($this->ip,$cfg['font-size'],8,2,$cfg['title'],$colors['font-color']);

		}
		catch(Exception $ex)
		{
			$this->parseErrorImage($ex->getMessage());
		}
		
		$this->parse($file);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseHorizontalPolygonGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: void
	 * @Access: public
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses a horizontal line graph
	*/
	public function parseHorizontalPolygonGraph($data,$cfg=array())
	{
		//Var
		$file = NULL;

		try
		{
			//Validate cfg & data arrays
			$cfg = $this->validate($cfg,$data);
			$dimensions = $this->calculateHorizontalColumnGraph($cfg,$data);
			
			//Test file
			if(!empty($cfg['file-name']))
				$file = $cfg['file-name'];
			
			//Create imgage
			$this->createImage($cfg['width'],$cfg['height']);
			
			//Create colors
			$colors = $this->getColors($cfg);
			
			//Test transparent background
			if($cfg['transparent-background']>0)
				imagecolortransparent($this->ip,$colors['background-color']);
			
			//Draw default blocks
			$this->drawBackground($colors['background-color'],$dimensions);
			$this->drawGraphBackground($colors['graph-background-color'],$dimensions);
			$this->drawGraphBorder($colors['border-color'],$dimensions);

			//Var
			$columnIndex = 0;
			$prevX = $dimensions['nullX'];
			$prevY = $dimensions['topOffset'];
			$prevValue = 0;

			foreach($dimensions['columns'] as $columnData)
			{
				//Test allocateRandomColors
				if($cfg['random-column-color'])
				{
					$randomColors = $this->allocateRandomColors();
					$colors['column-color'] = $randomColors['forecolor'];
					$colors['column-shadow-color'] = $randomColors['backcolor'];
				}
			
					//Add
					//imagefilledrectangle($this->ip,$columnData['shadowRectangle']['x1'],$columnData['shadowRectangle']['y1'],$columnData['shadowRectangle']['x2'],$columnData['shadowRectangle']['y2'],$colors['column-shadow-color']);
					//imagefilledrectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-color']);
					//imagerectangle($this->ip,$columnData['innerRectangle']['x1'],$columnData['innerRectangle']['y1'],$columnData['innerRectangle']['x2'],$columnData['innerRectangle']['y2'],$colors['column-shadow-color']);
					
					
					//Print line
					if($columnData['value']>=0)
					{
						
						
						if($prevValue>=0)
						{
							$pol[0] = $prevX;
							$pol[1] = $prevY;
							$pol[2] = $columnData['rectangle']['x2'];
							$pol[3] = $columnData['rectangle']['y2'];
							$pol[4] = $dimensions['nullX'];
							$pol[5] = $pol[3];
							$pol[6] = $dimensions['nullX'];
							$pol[7] = $pol[1];
						}
						else
						{
							$pol[0] = $dimensions['nullX'];
							$pol[1] = $prevY;
							$pol[2] = $columnData['rectangle']['x2'];
							$pol[3] = $columnData['rectangle']['y2'];
							$pol[4] = $dimensions['nullX'];
							$pol[5] = $columnData['rectangle']['y2'];
							$pol[6] = $dimensions['nullX'];
							$pol[7] = $columnData['rectangle']['y1'];
						}						
						
						
						
						imagefilledpolygon($this->ip,$pol,4,$colors['column-color']); //);
						//imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2'],$columnData['rectangle']['y1'],$colors['column-shadow-color']);
						
						//Re-map 
						$prevX = $columnData['rectangle']['x2'];
						$prevY = $columnData['rectangle']['y2'];

					}
					else
					{
									
						
						
						if($prevValue<0)
						{
							$pol[0] = $prevX;
							$pol[1] = $prevY;
							$pol[2] = $columnData['rectangle']['x1'];
							$pol[3] = $columnData['rectangle']['y2'];
							$pol[4] = $dimensions['nullX'];
							$pol[5] = $columnData['rectangle']['y2'];
							$pol[6] = $dimensions['nullX'];
							$pol[7] = $columnData['rectangle']['y1'];
						}
						else
						{
							$pol[0] = $dimensions['nullX'];
							$pol[1] = $prevY;
							$pol[2] = $columnData['rectangle']['x1'];
							$pol[3] = $columnData['rectangle']['y2'];
							$pol[4] = $dimensions['nullX'];
							$pol[5] = $columnData['rectangle']['y2'];
							$pol[6] = $dimensions['nullX'];
							$pol[7] = $columnData['rectangle']['y1'];						
						}


						imagefilledpolygon($this->ip,$pol,4,$colors['column-color']);
						//imageline($this->ip,$prevX,$prevY,$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['column-color']);	
						
						//Re-map 
						$prevX = $columnData['rectangle']['x1'];
						$prevY = $columnData['rectangle']['y2'];

					}

					//Map prev value
					$prevValue = $columnData['value'];

					//Print value
					if($cfg['disable-values']<1)
						imagestring($this->ip,$cfg['font-size'],$dimensions['nullX']+4,$columnData['text-position']['y'],$columnData['value'],$colors[$columnData['color']]);
					
					//Print legenda
					if($cfg['disable-legenda']<1)
						imagestring($this->ip,$cfg['font-size'],$columnData['legenda-position']['x'],$columnData['legenda-position']['y'],$columnData['key'],$colors['font-color']);
					
					//imagerectangle($this->ip,$columnData['rectangle']['x1'],$columnData['rectangle']['y1'],$columnData['rectangle']['x2'],$columnData['rectangle']['y2'],$colors['border-color']);
			}
			
			//Draw 0 & null line
			imagestring($this->ip,$cfg['font-size'],$dimensions['nullX']-(imagefontwidth($cfg['font-size'])/2),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),"0",$colors['font-color']);
			//imageline($this->ip,$dimensions['nullX'],$dimensions['topOffset']-8,$dimensions['nullX'],($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$colors['border-color']);

			//Draw min
			if($cfg['min']<0)
				imagestring($this->ip,$cfg['font-size'],$dimensions['leftOffset']-(imagefontheight($cfg['font-size'])/2),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$cfg['min'],$colors['font-color']);
		
			//Draw max
			imagestring($this->ip,$cfg['font-size'],(($dimensions['leftOffset']+$dimensions['graphBlock']['width'])-(imagefontwidth($cfg['font-size'])/2)),($dimensions['topOffset']+$dimensions['graphBlock']['height']+8),$cfg['max'],$colors['font-color']);

			//Draw title
			imagestring($this->ip,$cfg['font-size'],8,2,$cfg['title'],$colors['font-color']);

		}
		catch(Exception $ex)
		{
			$this->parseErrorImage($ex->getMessage());
		}
		
		$this->parse($file);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: validate
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg, (array) data
	 * @Return: (array) cfg
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Constructor
	*/
	private function validate($cfg,$data)
	{
		//Var
		$manditoryKeys = array
		(
			'title'=>array('type'=>'text','default'=>''),
			'width'=>array('type'=>'int','default'=>'200'),
			'height'=>array('type'=>'int','default'=>'200'),
			'font-size'=>array('type'=>'int','default'=>2),
			'background-color'=>array('type'=>'color','default'=>'FFFFFF'),
			'graph-background-color'=>array('type'=>'color','default'=>'E2E1E2'),
			'font-color'=>array('type'=>'color','default'=>'006699'),
			'column-font-color-q1'=>array('type'=>'color','default'=>'000000'),
			'column-font-color-q2'=>array('type'=>'color','default'=>'000000'),
			'border-color'=>array('type'=>'color','default'=>'006699'),
			'column-color'=>array('type'=>'color','default'=>'0099CC'),
			'column-shadow-color'=>array('type'=>'color','default'=>'006699'),
			'min-col-width'=>array('type'=>'int','default'=>'32'),
			'background-color-alpha'=>array('type'=>'int','default'=>0),
			'graph-background-color-alpha'=>array('type'=>'int','default'=>0),
			'font-color-alpha'=>array('type'=>'int','default'=>0),
			'column-font-color-q1-alpha'=>array('type'=>'int','default'=>0),
			'column-font-color-q2-alpha'=>array('type'=>'int','default'=>0),
			'border-color-alpha'=>array('type'=>'int','default'=>0),
			'column-color-alpha'=>array('type'=>'int','default'=>0),
			'column-shadow-color-alpha'=>array('type'=>'int','default'=>0),
			'transparent-background'=>array('type'=>'bool','default'=>0),
			'random-column-color'=>array('type'=>'bool','default'=>0),
			'disable-legenda'=>array('type'=>'bool','default'=>0),
			'disable-values'=>array('type'=>'bool','default'=>0),
			'file-name'=>array('type'=>'text','default'=>NULL),
		);
	
		//Test if CFG is array
		if(!is_array($cfg))
			throw new Exception('Cfg is not an array');
			
		//Test all manditory cfg keys
		foreach($manditoryKeys as $keyName=>$keyData)
		{
			if(array_key_exists($keyName,$cfg))
			{
				switch($keyData['type'])
				{
					case "int":
						if(!is_numeric($cfg[$keyName]))
							$cfg[$keyName] = $keyData['default']; 
					break;
					
					default:
					break;
				}
			}
			else
			{
				$cfg[$keyName] = $keyData['default'];
			}
		}
		
		//Test if data is array
		if(!is_array($data))
			throw new Exception('Data is not an array');

		//Test if data is populated
		if(empty($data))
			throw new Exception('No data provided array');
		
		//Set max key length
		$cfg['maxKeyLength'] = 0;
		
		//Loop all data memebers
		foreach($data as $key=>$value)
		{
			$keyLength = strlen($key);
			if($cfg['maxKeyLength']<$keyLength)
				$cfg['maxKeyLength'] = $keyLength;

			if(!is_numeric($value))
				throw new Exception(sprintf('Data for array key "%s" is not numeric',$key));
		}
		
		//Pre-Calculate defined values
		$cfg['cols'] = count($data);
		$cfg['max'] = max($data);
		$cfg['min'] = min($data);
		
		//if( $cfg['max']==0 && $cfg['min']==0)
			//throw new Exception(sprintf('All values are NULL'));
		
		return $cfg;	
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: calculateVerticalColumnGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: & (array) cfg, & (array) data
	 * @Return: (array) dimensions
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Calculates all dimensions for vertical line graph
	*/
	private function calculateVerticalColumnGraph(&$cfg,&$data)
	{
		//Var
		$dimensions = array();

		//Pre-calculate image width
		$minWidth = (((imagefontwidth($cfg['font-size'])*strlen($cfg['max']) )+8)*2)+($cfg['cols']*$cfg['min-col-width']);
		
		if($cfg['width']<$minWidth)
			$cfg['width'] = $minWidth;
		
		//Calculate offsets
		$maxValueLength = strlen($cfg['max']);
		if(strlen($cfg['min'])>$maxValueLength)
			$maxValueLength = strlen($cfg['min']);
			
		$dimensions['leftOffset'] = (imagefontwidth($cfg['font-size'])*$maxValueLength )+16;
		$dimensions['rightOffset'] = $dimensions['leftOffset'];
		$dimensions['topOffset'] = imagefontheight($cfg['font-size'])+16;
		$dimensions['bottomOffset'] = (imagefontwidth($cfg['font-size'])*$cfg['maxKeyLength'])+16;

		//Calculate graph display block
		$dimensions['graphBlock']['width'] = ($cfg['width']-$dimensions['leftOffset'])-$dimensions['rightOffset'];
		$dimensions['graphBlock']['height'] =($cfg['height']-$dimensions['topOffset'])-$dimensions['bottomOffset'];
		$dimensions['graphBlock']['x1'] = $dimensions['leftOffset'];
		$dimensions['graphBlock']['y1'] = $dimensions['topOffset'];
		$dimensions['graphBlock']['x2'] = $cfg['width']-$dimensions['leftOffset'];
		$dimensions['graphBlock']['y2'] = $dimensions['topOffset']+$dimensions['graphBlock']['height'];
		
		//Calculate background block
		$dimensions['backgroundBlock']['x1'] = 0;
		$dimensions['backgroundBlock']['y1'] = 0;
		$dimensions['backgroundBlock']['x2'] = $cfg['width'];
		$dimensions['backgroundBlock']['y2'] = $cfg['height'];

		//Calculate col width
		$dimensions['colCalculatieHeight'] = floor($dimensions['graphBlock']['width']/$cfg['cols']);
		$dimensions['colWidth'] = ($dimensions['graphBlock']['width']/$cfg['cols']);
		$dimensions['colInnerWidth'] = ($dimensions['graphBlock']['width']/$cfg['cols'])-10;

		//Calc range
		if($cfg['min']<0)
		{
			$dimensions['range'] = $cfg['max']-$cfg['min'];
			$dimensions['quadrant1Max'] = $cfg['max'];
			$dimensions['quadrant2Max'] = (0-$cfg['min']);
			$dimensions['quadrant1Percentage'] = @round($cfg['max']/($dimensions['range']/100));
			$dimensions['quadrant2Percentage'] = @round((0-$cfg['min'])/($dimensions['range']/100));
			$dimensions['quadrant1Height'] = round(($dimensions['graphBlock']['height']/100)*$dimensions['quadrant1Percentage']);
			$dimensions['quadrant2Height'] = round(($dimensions['graphBlock']['height']/100)*$dimensions['quadrant2Percentage']);
			$dimensions['nullY'] = $dimensions['topOffset']+$dimensions['quadrant1Height'];
			
			$dimensions['quadrant1CalcHeight'] = ($dimensions['quadrant1Height']>10) ? $dimensions['quadrant1Height']-10 : $dimensions['quadrant1Height'];
			$dimensions['quadrant2CalcHeight'] = ($dimensions['quadrant2Height']>10) ? $dimensions['quadrant2Height']-10 : $dimensions['quadrant2Height'];
			
		}
		else
		{
			$dimensions['range'] = $cfg['max'];
			$dimensions['quadrant1Max'] = $cfg['max'];
			$dimensions['quadrant2Max'] = 0;
			$dimensions['quadrant1Percentage'] = 100;
			$dimensions['quadrant2Percentage'] = 0;
			$dimensions['quadrant1Height'] = $dimensions['graphBlock']['height'];
			$dimensions['quadrant2Height'] = 0;
			$dimensions['quadrant1CalcHeight'] = $dimensions['graphBlock']['height']-10;
			$dimensions['quadrant2CalcHeight'] = 0;
			$dimensions['nullY'] = $dimensions['topOffset']+$dimensions['graphBlock']['height'];
		}


		//Var
		$columnIndex = 0;

		//Set arrays
		$dimensions['columns'] = array();

		//Col start
		foreach($data as $colKey=>$colValue)
		{
		
			if($colValue>=0)
			{
				//Calc
				$colHeightPercentage = ($dimensions['quadrant1CalcHeight']/100);
				$colHeight = @floor(($colValue/($dimensions['quadrant1Max']/100))*$colHeightPercentage);
				
				//Calculate text position
				$q1Height = $dimensions['quadrant1CalcHeight']-$colHeight;
				$q2Height = $colHeight;
				$maxHeight = $q1Height;
				$textPos = 'q1';
				if($q1Height<$q2Height)
				{
					$textPos = 'q2';
					$maxHeight = $q2Height;
				}
				
				//Create
				$columnData = array();
				
				//Set
				$columnData['text-pos'] = $textPos;
				$columnData['key'] = $colKey;
				$columnData['value'] = $colValue;
								
				$columnData['rectangle']['x1'] = $dimensions['leftOffset']+($columnIndex*$dimensions['colWidth']);
				$columnData['rectangle']['y1'] = $dimensions['nullY']-$colHeight;
				$columnData['rectangle']['x2'] = $columnData['rectangle']['x1']+$dimensions['colWidth'];
				$columnData['rectangle']['y2'] = $dimensions['nullY'];

				$columnData['innerRectangle']['x1'] = $columnData['rectangle']['x1']+4;
				$columnData['innerRectangle']['y1'] = $columnData['rectangle']['y1'];
				$columnData['innerRectangle']['x2'] = $columnData['rectangle']['x2']-6;
				$columnData['innerRectangle']['y2'] = $columnData['rectangle']['y2'];

				$columnData['shadowRectangle']['x1'] = $columnData['rectangle']['x1']+6;
				$columnData['shadowRectangle']['y1'] = $columnData['rectangle']['y1']-2;
				$columnData['shadowRectangle']['x2'] = $columnData['rectangle']['x2']-4;
				$columnData['shadowRectangle']['y2'] = $columnData['rectangle']['y2'];

				//
				$colWidth = $columnData['rectangle']['x2']-$columnData['rectangle']['x1'];
				$fontXoffset = (($colWidth/2)-(imagefontheight($cfg['font-size'])/2)-1);

				$columnData['text-position']['x'] = $columnData['rectangle']['x1']+$fontXoffset;
				$columnData['text-position']['y'] = ($textPos=='q1') ? $columnData['rectangle']['y1']-8: $columnData['rectangle']['y2']-8;

				$columnData['legenda-position']['x'] = $columnData['rectangle']['x1']+$fontXoffset;
				$columnData['legenda-position']['y'] = ($dimensions['graphBlock']['height']+$dimensions['topOffset'])+(imagefontwidth($cfg['font-size'])*strlen($colKey))+2;

								
				$columnData['color'] = 'column-font-color-'.$columnData['text-pos'];
				
				//Append collumn
				$dimensions['columns'][] = $columnData;
			}
			else
			{
				//Calc
				$colHeightPercentage = ($dimensions['quadrant2CalcHeight']/100);
				$colHeight = floor(($colValue/($dimensions['quadrant2Max']/100))*$colHeightPercentage);
				
				//Calculate text position
				$q1Height = 0-$colHeight;
				$q2Height = $dimensions['quadrant2CalcHeight']+$colHeight;
				$maxHeight = $q1Height;
				$textPos = 'q2';
				if($q1Height<$q2Height)
				{
					$textPos = 'q1';
					$maxHeight = $q2Height;
				}
				
				//Create
				$columnData = array();
				
				//Set
				$columnData['text-pos'] = $textPos;
				$columnData['key'] = $colKey;
				$columnData['value'] = $colValue;
				
				$columnData['rectangle']['x1'] = $dimensions['leftOffset']+($columnIndex*$dimensions['colWidth']);
				$columnData['rectangle']['y1'] = $dimensions['nullY'];
				$columnData['rectangle']['x2'] = $columnData['rectangle']['x1']+$dimensions['colWidth'];
				$columnData['rectangle']['y2'] = $dimensions['nullY']-$colHeight;

				$columnData['innerRectangle']['x1'] = $columnData['rectangle']['x1']+4;
				$columnData['innerRectangle']['y1'] = $columnData['rectangle']['y1'];
				$columnData['innerRectangle']['x2'] = $columnData['rectangle']['x2']-6;
				$columnData['innerRectangle']['y2'] = $columnData['rectangle']['y2'];

				$columnData['shadowRectangle']['x1'] = $columnData['rectangle']['x1']+6;
				$columnData['shadowRectangle']['y1'] = $columnData['rectangle']['y1'];
				$columnData['shadowRectangle']['x2'] = $columnData['rectangle']['x2']-4;
				$columnData['shadowRectangle']['y2'] = $columnData['rectangle']['y2']-2;
				
				
				$colWidth = $columnData['rectangle']['x2']-$columnData['rectangle']['x1'];
				$fontXoffset = (($colWidth/2)-(imagefontheight($cfg['font-size'])/2))-1;
				
				$textOffset = (imagefontwidth($cfg['font-size'])*strlen($colValue))+4;
				if($textOffset<$maxHeight)
				{
				
					$columnData['text-position']['x'] = $columnData['rectangle']['x1']+$fontXoffset;
					$columnData['text-position']['y'] = ($textPos=='q2') ? ($columnData['rectangle']['y1']+$textOffset): ($columnData['rectangle']['y2']+$textOffset);
				}
				else
				{
					$columnData['text-position']['x'] = $columnData['rectangle']['x1']+$fontXoffset;
					$columnData['text-position']['y'] = $columnData['rectangle']['y1']-8;
					$columnData['text-pos'] = 'q1';
				}				

				$columnData['color'] = 'column-font-color-'.$columnData['text-pos'];
				$columnData['legenda-position']['x'] = $columnData['rectangle']['x1']+$fontXoffset;
				$columnData['legenda-position']['y'] = ($dimensions['graphBlock']['height']+$dimensions['topOffset'])+(imagefontwidth($cfg['font-size'])*strlen($colKey))+2;
				
				
				//Append collumn
				$dimensions['columns'][] = $columnData;
			
			}
			//Add
			$columnIndex++;
			
		}


		
		//Return
		return $dimensions;
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: calculateHorizontalColumnGraph
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: & (array) cfg, & (array) data
	 * @Return: (array) dimensions
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Calculates all dimensions for horizontal line graph
	*/
	private function calculateHorizontalColumnGraph(&$cfg,&$data)
	{
		//Var
		$dimensions = array();

		//Pre-calculate image height
		$minHeight = (((imagefontwidth($cfg['font-size'])*strlen($cfg['max']) )+8)*2)+($cfg['cols']*$cfg['min-col-width']);
		
		if($cfg['height']<$minHeight)
			$cfg['height'] = $minHeight;
			
		//Calculate offsets
		$maxValueLength = strlen($cfg['max']);
		if(strlen($cfg['min'])>$maxValueLength)
			$maxValueLength = strlen($cfg['min']);
			
		$dimensions['bottomOffset'] = (imagefontwidth($cfg['font-size'])*$maxValueLength )+16;
		$dimensions['topOffset'] = imagefontheight($cfg['font-size'])+16;
		$dimensions['leftOffset'] = (imagefontwidth($cfg['font-size'])*$cfg['maxKeyLength'])+16;
		$dimensions['rightOffset'] = $dimensions['leftOffset'];
		
		//Calculate graph display block
		$dimensions['graphBlock']['width'] = ($cfg['width']-$dimensions['leftOffset'])-$dimensions['rightOffset'];
		$dimensions['graphBlock']['height'] =($cfg['height']-$dimensions['topOffset'])-$dimensions['bottomOffset'];
		$dimensions['graphBlock']['x1'] = $dimensions['leftOffset'];
		$dimensions['graphBlock']['y1'] = $dimensions['topOffset'];
		$dimensions['graphBlock']['x2'] = $cfg['width']-$dimensions['leftOffset'];
		$dimensions['graphBlock']['y2'] = $dimensions['topOffset']+$dimensions['graphBlock']['height'];
		
		//Calculate background block
		$dimensions['backgroundBlock']['x1'] = 0;
		$dimensions['backgroundBlock']['y1'] = 0;
		$dimensions['backgroundBlock']['x2'] = $cfg['width'];
		$dimensions['backgroundBlock']['y2'] = $cfg['height'];

		//Calculate col width
		$dimensions['colHeight'] = ($dimensions['graphBlock']['height']/$cfg['cols']);
		$dimensions['colInnerHeight'] = ($dimensions['graphBlock']['height']/$cfg['cols'])-10;

		//Calc range
		if($cfg['min']<0)
		{
			$dimensions['range'] = $cfg['max']-$cfg['min'];
			$dimensions['quadrant1Max'] = $cfg['max'];
			$dimensions['quadrant2Max'] = (0-$cfg['min']);
			$dimensions['quadrant1Percentage'] = @round($cfg['max']/($dimensions['range']/100));
			$dimensions['quadrant2Percentage'] = @round((0-$cfg['min'])/($dimensions['range']/100));
			$dimensions['quadrant1Width'] = round(($dimensions['graphBlock']['width']/100)*$dimensions['quadrant1Percentage']);
			$dimensions['quadrant2Width'] = round(($dimensions['graphBlock']['width']/100)*$dimensions['quadrant2Percentage']);
			$dimensions['nullX'] = $dimensions['leftOffset']+$dimensions['quadrant2Width'];
			$dimensions['quadrant1CalcWidth'] = ($dimensions['quadrant1Width']>10) ? $dimensions['quadrant1Width']-10 : $dimensions['quadrant1Width'];
			$dimensions['quadrant2CalcWidth'] = ($dimensions['quadrant2Width']>10) ? $dimensions['quadrant2Width']-10 : $dimensions['quadrant2Width'];
		}
		else
		{
			$dimensions['range'] = $cfg['max'];
			$dimensions['quadrant1Max'] = $cfg['max'];
			$dimensions['quadrant2Max'] = 0;
			$dimensions['quadrant1Percentage'] = 100;
			$dimensions['quadrant2Percentage'] = 0;
			$dimensions['quadrant1Width'] = $dimensions['graphBlock']['width'];
			$dimensions['quadrant2Width'] = 0;
			$dimensions['quadrant1CalcWidth'] = $dimensions['graphBlock']['width']-10;
			$dimensions['quadrant2CalcWidth'] = 0;
			$dimensions['nullX'] = $dimensions['leftOffset'];
		}


		//Var
		$columnIndex = 0;

		//Set arrays
		$dimensions['columns'] = array();

		//Col start
		foreach($data as $colKey=>$colValue)
		{
		
			if($colValue>=0)
			{
				//Calc
				$colWidthPercentage = ($dimensions['quadrant1CalcWidth']/100);
				$colWidth = @floor(($colValue/($dimensions['quadrant1Max']/100))*$colWidthPercentage);
				
				//Calculate text position
				$q1Width = $dimensions['quadrant1CalcWidth']-$colWidth;
				$q2Width = $colWidth;
				$maxWidth = $q1Width;
				$textPos = 'q1';
				if($q1Width<$q2Width)
				{
					$textPos = 'q2';
					$maxWidth = $q2Width;
				}
				
				//Create
				$columnData = array();
				
				//Set
				$columnData['text-pos'] = $textPos;
				$columnData['key'] = $colKey;
				$columnData['value'] = $colValue;
								
				$columnData['rectangle']['x1'] = $dimensions['nullX']; 
				$columnData['rectangle']['y1'] = $dimensions['topOffset']+($columnIndex*$dimensions['colHeight']);
				$columnData['rectangle']['x2'] = $dimensions['nullX']+$colWidth;
				$columnData['rectangle']['y2'] = $columnData['rectangle']['y1']+$dimensions['colHeight'];

				$columnData['innerRectangle']['x1'] = $columnData['rectangle']['x1'];
				$columnData['innerRectangle']['y1'] = $columnData['rectangle']['y1']+4;
				$columnData['innerRectangle']['x2'] = $columnData['rectangle']['x2'];
				$columnData['innerRectangle']['y2'] = $columnData['rectangle']['y2']-6;

				$columnData['shadowRectangle']['x1'] = $columnData['rectangle']['x1'];
				$columnData['shadowRectangle']['y1'] = $columnData['rectangle']['y1']+6;
				$columnData['shadowRectangle']['x2'] = $columnData['rectangle']['x2']+2;
				$columnData['shadowRectangle']['y2'] = $columnData['rectangle']['y2']-4;

				//Cal
				$colHeight = $columnData['rectangle']['y2']-$columnData['rectangle']['y1'];
				$fontYoffset = (($colHeight/2)-(imagefontheight($cfg['font-size'])/2)-1);
				
				//Set
				$columnData['text-position']['x'] = ($textPos=='q1') ? $columnData['rectangle']['x2']+8: $columnData['rectangle']['x1']+8;
				$columnData['text-position']['y'] = $columnData['rectangle']['y1']+$fontYoffset;
				$columnData['legenda-position']['x'] = 4;
				$columnData['legenda-position']['y'] = $columnData['rectangle']['y1']+$fontYoffset;
				$columnData['color'] = 'column-font-color-'.$columnData['text-pos'];
				
				//Append collumn
				$dimensions['columns'][] = $columnData;
			}
			else
			{
				//Calc
				$colWidthPercentage = ($dimensions['quadrant2CalcWidth']/100);
				$colWidth = floor(($colValue/($dimensions['quadrant2Max']/100))*$colWidthPercentage);
				
				//Calculate text position
				$q1Width = 0-$colWidth;
				$q2Width = $dimensions['quadrant2CalcWidth']+$colWidth;
				$maxWidth = $q1Width;
				$textPos = 'q2';
				if($q1Width<$q2Width)
				{
					$textPos = 'q1';
					$maxWidth = $q2Width;
				}
				
				//Create
				$columnData = array();
				
				//Set
				$columnData['text-pos'] = $textPos;
				$columnData['key'] = $colKey;
				$columnData['value'] = $colValue;
				
				$columnData['rectangle']['x1'] = $dimensions['nullX']+$colWidth;
				$columnData['rectangle']['y1'] = $dimensions['topOffset']+($columnIndex*$dimensions['colHeight']);
				$columnData['rectangle']['x2'] = $dimensions['nullX'];
				$columnData['rectangle']['y2'] = $columnData['rectangle']['y1']+$dimensions['colHeight'];
				
				$columnData['innerRectangle']['x1'] = $columnData['rectangle']['x1'];
				$columnData['innerRectangle']['y1'] = $columnData['rectangle']['y1']+4;
				$columnData['innerRectangle']['x2'] = $columnData['rectangle']['x2'];
				$columnData['innerRectangle']['y2'] = $columnData['rectangle']['y2']-6;

				$columnData['shadowRectangle']['x1'] = $columnData['rectangle']['x1']+2;
				$columnData['shadowRectangle']['y1'] = $columnData['rectangle']['y1']+6;
				$columnData['shadowRectangle']['x2'] = $columnData['rectangle']['x2'];
				$columnData['shadowRectangle']['y2'] = $columnData['rectangle']['y2']-4;
				
				
				$colHeight = $columnData['rectangle']['y2']-$columnData['rectangle']['y1'];
				$fontYoffset = (($colHeight/2)-(imagefontheight($cfg['font-size'])/2))-1;
				
				$textOffset = (imagefontwidth($cfg['font-size'])*strlen($colValue))+4;
				if($textOffset<$maxWidth)
				{
				
					$columnData['text-position']['x'] = ($textPos=='q2') ? ($columnData['rectangle']['x2']-$textOffset): ($columnData['rectangle']['x1']-$textOffset); 
					$columnData['text-position']['y'] = $columnData['rectangle']['y1']+$fontYoffset;
				}
				else
				{
					$columnData['text-position']['x'] = $columnData['rectangle']['x1']-8;
					$columnData['text-position']['y'] = $columnData['rectangle']['y1']+$fontYoffset;
					$columnData['text-pos'] = 'q1';
				}				

				$columnData['color'] = 'column-font-color-'.$columnData['text-pos'];
				$columnData['legenda-position']['x'] = 4;//$columnData['rectangle']['x1']+$fontYoffset;
				$columnData['legenda-position']['y'] = $columnData['rectangle']['y1']+$fontYoffset;//($dimensions['graphBlock']['height']+$dimensions['topOffset'])+(imagefontwidth($cfg['font-size'])*strlen($colKey))+2;
				
				
				//Append collumn
				$dimensions['columns'][] = $columnData;
			
			}
			//Add
			$columnIndex++;
			
		}
	
		//Return
		return $dimensions;
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: drawGraphBorder
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (object) color, & (array) dimensions
	 * @Return: void
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Draws a border arround graph background
	*/
	private function drawGraphBorder($color,$dimensions)
	{
		if(isset($dimensions['graphBlock']))
		{
			imagerectangle($this->ip,$dimensions['graphBlock']['x1'],$dimensions['graphBlock']['y1'],$dimensions['graphBlock']['x2'],$dimensions['graphBlock']['y2'],$color );
		}
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: drawGraphBackground
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (object) color, & (array) dimensions
	 * @Return: void
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Draws a the graph background
	*/
	private function drawGraphBackground($color,$dimensions)
	{
		if(isset($dimensions['graphBlock']))
		{
			imagefilledrectangle($this->ip,$dimensions['graphBlock']['x1'],$dimensions['graphBlock']['y1'],$dimensions['graphBlock']['x2'],$dimensions['graphBlock']['y2'],$color );
		}
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: drawBackground
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (object) color, & (array) dimensions
	 * @Return: void
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Draws the complete background
	*/
	private function drawBackground($color,$dimensions)
	{

		if(isset($dimensions['backgroundBlock']))
		{
			$col = $this->allocateColor('FF0000');
			imagefilledrectangle($this->ip,$dimensions['backgroundBlock']['x1'],$dimensions['backgroundBlock']['y1'],$dimensions['backgroundBlock']['x2'],$dimensions['backgroundBlock']['y2'],$color);
		}
	}

//-------------------------------------------------------------------------------

	/**
	 * @Name: getColors
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (array) cfg
	 * @Return: (array) colors
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Sets and returnes array of colors
	*/
	private function getColors($cfg)
	{
		$colors = array();
		$colorKeys = array('background-color','font-color','border-color','column-color','column-shadow-color','column-font-color-q1','column-font-color-q2','graph-background-color');

		foreach($colorKeys as $colorkey)
		{
			if(isset($cfg[$colorkey]))
				$colors[$colorkey] = $this->allocateColor($cfg[$colorkey],@$cfg[$colorkey."-alpha"]);
			else
				$colors[$colorkey] = $this->allocateColor('000000');
		}
		return $colors;
	}

//-------------------------------------------------------------------------------

	/**
	 * @Name: parse
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (object) color, & (array) dimensions
	 * @Return: void
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses the image pointer
	*/
	private function parse($file=null)
	{
		if($file)
			imagepng($this->ip,$file);
		else
			imagepng($this->ip);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: createImage
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (int) width, (int) height
	 * @Return: void
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Creates a blank image
	*/
	private function createImage($width,$height)
	{
		$this->ip = imagecreatetruecolor($width,$height);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: parseErrorImage
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (string) message
	 * @Return: void
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Parses an error image
	*/
	private function parseErrorImage($message)
	{
		$width = (imagefontwidth(2)*strlen($message))+8;
		$this->createImage($width,20);
		$col = imagecolorallocate($this->ip,255,0,0);
		$bgc = imagecolorallocate($this->ip,255,255,255);
		imagefilledrectangle($this->ip,0,0,$width,20,$bgc);
		imagestring($this->ip,2,4,2,$message,$col);
	}	

//--------------------------------------------------------------------------------

	/**
	 * @Name: allocateColor
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (string) hexColor, (int) alpha
	 * @Return: (object) color
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Allocates alpha color
	*/
	private function allocateColor($hexColor,$alpha=0)
	{
		$rgb = $this->hex2Rgb($hexColor);
		return imagecolorallocatealpha($this->ip,$rgb['r'],$rgb['g'],$rgb['b'],$alpha);
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: allocateRandomColors
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (string) hexColor, (int) alpha
	 * @Return: (object) color
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Allocates random color
	*/
	private function allocateRandomColors($alpha=0)
	{
		$r = rand(70,300);
		$g = rand(70,300);
		$b = rand(70,300);

		$colors['forecolor'] = imagecolorallocatealpha($this->ip,$r,$g,$b,$alpha);
		//$colors['backcolor'] =imagecolorallocatealpha($this->ip,$r-5,$g-5,$b-5,$alpha);
		$colors['backcolor']=$colors['forecolor'];
		return $colors;
	}

//--------------------------------------------------------------------------------

	/**
	 * @Name: hex2Rgb
	 * @Author: Martijn Beulens <m.beulens@abisvmm.nl>
	 * @Param: (string) hexColor
	 * @Return: (array) rgb
	 * @Access: private
	 * @Exception: no
	 * @Since: version Sun 13 apr 2008
	 * @Comment: Converst a hexcolor to an RGB array
	*/
	private function hex2Rgb($hexColor)
	{
		//Var
		$rgb = array();
		
		//Strip #
		$hexColor = str_replace("#", '', $hexColor);
		
		//Convert to r g b
		$rgb['r'] = hexdec(substr($hexColor, 0, 2));
        $rgb['g'] = hexdec(substr($hexColor, 2, 2));
        $rgb['b'] = hexdec(substr($hexColor, 4, 2));		
		
		//Return 
		return $rgb;
	}

//--------------------------------------------------------------------------------

} //End class


?>