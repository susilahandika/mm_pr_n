<table width="100%" class="table table-hover" id="dataTables-example" style='white-space: nowrap; table-layout: fixed;'>
    <thead>
        <tr>
            <td width="10%">ID PR</td>
            <td width="15%">Tanggal PR</td>
            <td width="30%">Departemen</td>
            <td width="10%">Section</td>
            <td width="15%">User</td>
            <td width="10%">Supplier</td>
            <td width="10%">Proses BM</td>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($listpr as $value): ?>
        <tr>
            <td><a href="<?php echo base_url(); ?>purchaseRequisition/detailPr/<?php echo $value['id_pr']; ?>" title=""><?php echo $value['id_pr']; ?></a></td>
            <td><?php echo $value['tgl_pr']; ?></td>
            <td><?php echo $value['deptname']; ?></td>
            <td><?php echo $value['secname']; ?></td>
            <td><?php echo $value['nama']; ?></td>
            <td><?php echo $value['sup_name']; ?></td>
            <td><?php echo $value['tgl_prs_bm']; ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>