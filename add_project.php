<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>web zero</title>
        <link rel='stylesheet' href='css/bootstrap.min.css'/>
        <link rel='stylesheet' href='css/style.css'/>
        
    </head>
    <body>
       <form method="post" action="project.controller.php">
         <input type="hidden" name="action" value="add-project">
        <div class="container">
          <h1>Add Project</h1>
           
            <div class="row">
             
              <div class= "col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                    Name  
                 </div>
              
              </div>
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <input type="text" name="Name">
              
              </div>

              </div>
     <div class="row">
              <div class= "col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                    StartDate  
                 </div>
              
              </div>
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <input type="date" name="StartDate">
              
              </div>
            </div>
      <div class="row">
              <div class= "col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                    EndDate  
                 </div>
              
              </div>
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <input type="date" name="EndDate">
              
              </div>

             
              </div>
        
                <div class="row">

                
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                    Cost
                 </div>
                 </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <input type="number" name="Cost" min="0"  >
                 
            </div>    
            </div>
              <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                     Hours/Day
                 </div>
              
           
              </div>
                       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <input type="number" name="HoursperDay" step="1" min="1" max="24">
              </div>
              </div>

             <div class="row">
               <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                     Members
                 </div>
              
           
              </div>
                       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 padding">
             <select multiple size="4" name="Members">
  <option value="volvo">member1</option>
  <option value="saab">member2</option>
  <option value="opel">member4</option>
  <option value="audi">member4</option>
  <option value="audi">member5</option>
</select>
           </div>  
            </div>
            
            
            <div class="row">
               <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <div class="label">
                     deliverables
                 </div>
              
           
              </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
             <input type="text" name="deliverables">
           </div> 
    <a class="btn btn-primary"  href="project.controller.php"> Add deliverable </a>
            </div>
            
            
            </div>
     
        <!--container-fluid (all page)-->
    

             <a class="btn btn-danger float-left  "   href="project.controller.php"> Add Project </a>
                         
        </form> 

        <script src="js/jquery.min.js"></script>

        <script src="js/bootstrap.min.js"></script>
        
         <script src="js/js.js"></script>  
    </body>
    
    
</html>


<!-- 
large screens       lg
medium screens      md
small screen        sm
extra small screen  xs



-->