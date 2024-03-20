<?php include "partials/header.php" ?>

<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>Categories</h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <div style="color: green; font-size:20px; text-align:center;">
                            <?php
                                if(isset($_SESSION['delete-success'])){
                                    echo $_SESSION['delete-success'];
                                    unset($_SESSION['delete-success']);
                                }

                                if(isset($_SESSION['update-success'])){
                                    echo $_SESSION['update-success'];
                                    unset($_SESSION['update-success']);
                                }

                            ?>
                    </div>

                    <div style="color: red; font-size:20px; text-align:center;">
                            <?php
                                if(isset($_SESSION['delete-error'])){
                                    echo $_SESSION['delete-error'];
                                    unset($_SESSION['delete-error']);
                                }

                            ?>
                    </div>
                  <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Parent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = mysqli_query($conn, "SELECT * FROM categories");
                                if(mysqli_num_rows($sql) > 0){
                                    $id = 1;
                                    while($row = mysqli_fetch_assoc($sql)){
                                        $disabled= json_decode($row['disabled']);
                                        ?>

                                    <tr style="font-size:18px">
                                        <td><?php  echo $id++;?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td>
                                            <button onclick="change_btn(event,<?php echo $row['id']; ?>)"   class="btn <?php echo $disabled?'btn-danger':'btn-primary' ?>">
                                                <?php echo $disabled?'Disable':'Enable' ?>
                                            </button>
                                        </td>
                                        <td><?php 
                                            $sql2 = mysqli_query($conn, "SELECT * FROM categories WHERE id = ".$row['parent'] ." LIMIT 1");
                                           
                                            if(mysqli_num_rows($sql2) == 1){
                                                $item = mysqli_fetch_assoc($sql2);
                                                echo $item['category'];
                                            }else{
                                                echo "";
                                            }
                                        
                                        
                                        ?></td>
                                        <td>
                                            <a href="edit-category.php?id=<?php echo $row['id'];  ?>"><button class="btn btn-success">Edit</button></a>
                                            <a href="delete-category.php?id=<?php echo $row['id'];  ?>"><button class="btn btn-warning">Delete</button></a> 
                                        </td>
                                    </tr>
                                    

                                        <?php
                                    }
                                }

                                ?>
                                
                            </tbody>
                    </table>

                
                </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->


         <script>

            function change_btn(e,id){
                const xhr = new XMLHttpRequest()
                xhr.open('POST', 'edit-category.php')
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status ==200){
                        let result = JSON.parse(xhr.responseText);
                        let changer = e.target

                        if(result == 0){
                            if(changer.classList.contains('btn-danger')){
                                changer.classList.remove('btn-danger')
                                changer.classList.add('btn-primary')
                                changer.innerText = 'Enable'
                            }

                        }else{
                            if(changer.classList.contains('btn-primary')){
                                changer.classList.remove('btn-primary')
                                changer.classList.add('btn-danger')
                                changer.innerText = 'Disable'
                                
                            }
                           
                            

                        }
                    }
                }
               let form = new FormData()
               form.append('id',id)
                xhr.send(form)
            }
         </script>


<?php include "partials/footer.php" ?>