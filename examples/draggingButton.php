<?php

class MovableButton extends wxButton
{

   function __construct($parent = null)
   {
      parent::__construct($parent, wxID_ANY, "Drag me around");

      $this->parent = $parent;
      $this->dragging = false;

      $this->Connect(wxEVT_LEFT_DOWN, array($this, "onMouseDown"));
      $this->Connect(wxEVT_MOTION, array($this, "onMove"));
      $this->Connect(wxEVT_LEFT_UP, array($this, "onMouseUp"));
   }

   public function onMouseDown(wxMouseEvent $evt)
   {
      $this->CaptureMouse();
      $this->x =  $evt->GetPosition()->x;
      $this->y =  $evt->GetPosition()->y;
      $this->dragging = true;
   }

   public function onMouseUp(wxMouseEvent $evt)
   {
      $this->ReleaseMouse();
      $this->dragging = false;
   }

   public function onMove(wxMouseEvent $evt)
   {
      if ($this->dragging)
      {
         $newx = wxGetMousePosition()->x  - $this->x;
         $newy = wxGetMousePosition()->y  - $this->y;
         $this->Move($this->parent->ScreenToClient(new wxPoint($newx, $newy)));
      }
   }
}


class MyFrame extends wxFrame
{

   function __construct($parent = null)
   {
      parent::__construct($parent, wxID_ANY, "Dragging a widget", wxDefaultPosition, new wxSize(640, 480));

      $mainPanel = new wxPanel($this, wxID_ANY);
      $MovableButton = new MovableButton($mainPanel);

      $this->Center();
      $this->Show();
   }

}

class MyApp extends wxApp
{

   public function OnInit()
   {
      $MyFrame = new MyFrame();

      return true;
   }

   function OnExit()
   {
      $this->Destroy();
      return 0;
   }

}

$myApp = new MyApp();
wxApp::SetInstance($myApp);
wxEntry();