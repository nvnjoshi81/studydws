<style>
    .box {
    border-radius: 3px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    padding: 10px 25px;
    text-align: right;
    display: block;
    margin-top: 60px;
}
.box-icon {
    background-color: #57a544;
    border-radius: 50%;
    display: table;
    height: 100px;
    margin: 0 auto;
    width: 100px;
    margin-top: -61px;
}
.box-icon span {
    color: #fff;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
.info h4 {
    font-size: 26px;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.info > p {
    color: #717171;
    font-size: 16px;
    padding-top: 10px;
    text-align: justify;
}
.info > a {
    background-color: #03a9f4;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
.info > a:hover {
    background-color: #0288d1;
    box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.12);
    color: #fff;
    transition: all 0.5s ease 0s;
}
</style><div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">&nbsp;</div>  
        <div class="col-md-3 col-sm-3">
            <?php $this->load->view('common/leftnav');?>
        </div>
    <div class="col-md-9 col-sm-9">
        <div class="box">
                <div class="info">
                    <p>The resource you are looking for might not exist; We are updating the content.Please visit again.</p>
                    <a href="<?php echo base_url(); ?>" class="btn">Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>