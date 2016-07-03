<?php

class MainWindow extends wxFrame
{
   function __construct($parent = null)
   {
      parent::__construct($parent, wxID_ANY, "Drag and Drop Sample", wxDefaultPosition, new wxSize(500, 300), wxDEFAULT_FRAME_STYLE | wxTAB_TRAVERSAL);
      $win = new TestPanel($this);
      $win->Show();
   }
}

class TestPanel extends wxPanel
{

   public function __construct($parent)
   {
      parent::__construct($parent, wxID_ANY, wxDefaultPosition, wxDefaultSize, wxTAB_TRAVERSAL, 'ProgressDialog');
      $b = new wxButton($this, wxID_ANY, "Create and Show a ProgressDialog", new wxPoint(50, 50));
      $b->connect(wxEVT_BUTTON, array($this, "OnButton"));
   }

   public function OnButton($event)
   {
      $max = 80;

      $dlg = new wxProgressDialog("Progress dialog example", "An informative message", $maximum = $max, null, $style = 0 | wxPD_APP_MODAL | wxPD_CAN_SKIP
              #| wx.PD_CAN_SKIP
              #| wx.PD_ELAPSED_TIME
              | wxPD_ESTIMATED_TIME | wxPD_REMAINING_TIME
              #| wx.PD_AUTO_HIDE
      );

      $count = 0;

      while ($count < $max)
      {
         $count += 1;
         sleep(1);
         //wx.Yield();

         if ($count >= $max / 2)
         {
            $dlg->Update($count, "Half-time!");
         }
         else
         {
            $dlg->Update($count);
         }
      }
      $dlg->Destroy();
   }
}

$win = new MainWindow();
$win->Show();
wxEntry();
