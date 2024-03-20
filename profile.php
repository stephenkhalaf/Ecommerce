<?php include "./partials/header.php" ?>
<section style="min-height:50vh;">
        <table class="table table-striped  table-hover">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody >
                <tr>
                    <td>1</td>
                    <td><?php echo $data['name'];  ?></td>
                    <td>$50</td>
                    <td><?php echo date("jS M Y",strtotime($data['date'])) ?></td>
                    <td>
                        <a href=""><button class="btn btn-success">Edit</button></a>
                        <a href=""><button class="btn btn-warning">Delete</button></a>
                    </td>
                </tr>
            </tbody>
    </table>
</section>

<?php include "./partials/footer.php" ?>