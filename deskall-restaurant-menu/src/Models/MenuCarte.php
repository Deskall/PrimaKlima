<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\AssetAdmin\Forms\UploadField;
use setasign\Fpdi\Tcpdf\Fpdi;
use SilverStripe\Assets\Folder;

class MenuCarte extends DataObject{

    private static $singular_name = 'Karte';

    private static $plural_name = 'Karte';

    private static $db = [
        'Title' => 'Varchar',
        'Date' => 'Date',
        'Format' => 'Enum("A5,A4","A4")'
    ];


    private static $has_many = [
    	'Elements' => MenuCarteElement::class
    ];

    private static $has_one = [
        'File' => File::class
    ];

    private static $owns = [
        'File'
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Date'] = _t(__CLASS__.'.Date','Datum');
        $labels['Elements'] = _t(__CLASS__.'.Elements','Menü Items');
        $labels['File'] = _t(__CLASS__.'.File','Menü Datei (PDF)');
       
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Elements');
        $fields->removeByName('File');
        // $fields->addFieldToTab('Root.Main',UploadField::create('File',$this->fieldLabels()['File'])->setFolderName($this->getFolderName()));
        if ($this->ID > 0){
            $config = GridFieldConfig_RecordEditor::create();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $config->addComponent(new GridFieldShowHideAction());
            $itemsField = new GridField('Elements',_t(__CLASS__.'.Elements','Elements'),$this->Elements(),$config);
            $fields->addFieldToTab('Root.Main',$itemsField);
        }
		

        return $fields;
    }

    public function getFolderName(){
        return "Uploads/Menu";
    }


    public function ActiveElements(){
        return $this->Elements()->filter('isVisible',1);
    }

    public function printPDF(){




      $pdf = new Fpdi();

      $pdf->AddPage();

      $html = '
      <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
      <i>This is the first example of TCPDF library.</i>
      <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
      <p>Please check the source code documentation and other examples for further information.</p>
      <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>';

      // Print text using writeHTMLCell()
      $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

      // $pdf->Addfont('Stone sans ITC','','stonesansitc.php');
      // $pdf->Addfont('Lato','','lato.php');
      // $pageCount = $pdf->setSourceFile($src);
      // for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
      //       $pdf->AddPage();
      //       $templateId = $pdf->importPage($pageNo);
      //       $size = $pdf->getTemplateSize($templateId);
      //       $pdf->useTemplate($templateId);
      //       $pdf->SetFont('Lato','',8);
      //       $pdf->setXY(8,60);
      //       $pdf->WriteHTML($this->parseString($config->Intro));
      //       $y = $pdf->GetY();
      //       $i = 6;
      //       $pdf->setXY(10,$y + $i);
      //       $pdf->SetFont('Stone sans ITC','',10);
      //       $pdf->WriteHTML("Angebot:");
      //       $pdf->SetFont('Lato','',8);
      //       $pdf->setXY(10,$y + $i*2);
      //       $pdf->WriteHtml("Einsatz:");
      //       $pdf->setXY(50,$y + $i*2);
      //       $pdf->WriteHtml($config->Usage);
      //       $pdf->setXY(10,$y + $i*3);
      //       $pdf->WriteHtml("Funktion:");
      //       $pdf->setXY(50,$y + $i*3);
      //       $pdf->WriteHtml($this->NiceJobTitle());
      //       $pdf->setXY(10,$y + $i*4);
      //       $pdf->WriteHtml("Einsatzzeitraum:");
      //       $pdf->setXY(50,$y + $i*4);
      //       $pdf->WriteHtml($this->Period);
      //       $pdf->setXY(10,$y + $i*5);
      //       $pdf->WriteHtml("Kosten:");
      //       $pdf->setXY(50,$y + $i*5);
      //       $pdf->WriteHtml($this->Price." pro Std., mindestens 8 Std. pro Tag, 50% Zuschläge an Sonn-und Feiertagen");
      //       $pdf->setXY(10,$y + $i*6);
      //       $pdf->WriteHtml("Fahrtkosten:");
      //       $pdf->setXY(50,$y + $i*6);
      //       $pdf->WriteHtml($config->TransportCost);
      //       $pdf->setXY(10,$y + $i*7);
      //       $pdf->WriteHtml("Kost&Logis:");
      //       $pdf->setXY(50,$y + $i*7);
      //       $pdf->WriteHtml($config->CostAndHousing);
      //       $pdf->setXY(10,$y + $i*8);
      //       $pdf->WriteHtml("Agentur-Gebühr:");
      //       $pdf->setXY(50,$y + $i*8);
      //       $pdf->WriteHtml($config->AgentCost);

      //       $pdf->setXY(8,$y + $i*10);
      //       $pdf->WriteHTML($this->parseString($config->Diverse));
      //       $y = $pdf->GetY();
      //       $pdf->setXY(8,$y + $i);
      //       $pdf->WriteHTML($this->parseString($config->Conditions));
      //        $y = $pdf->GetY();
      //       $pdf->setXY(10,$y + $i);
      //       $pdf->WriteHtml("Datum: ".date('d.m.Y'));
      //       $pdf->setXY(150,$y + $i);
      //       $pdf->WriteHtml("Kunde Unterschrift: ");
      // }
      // $pdf->Output($output,'F');
      


      $tmpFolder = "Uploads/Menus/".$this->ID;
      $folder = Folder::find_or_make($tmpFolder);
      $file = File::create();
      $file->ParentID = $folder->ID;
      $file->setFromLocalFile($output, 'Uploads/Menus/'.$this->ID.'/'.$this->Title.'.pdf');
      $file->write();
      $file->publishSingle();
      $this->FileID = $file->ID;
      $this->write();
      
    }
}
