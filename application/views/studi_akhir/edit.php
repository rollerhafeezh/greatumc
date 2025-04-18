<div class="content__boxed">
    <div class="content__wrap">

    	<style>
    		.nav::-webkit-scrollbar {display: none}
    	</style>
    	<div class="row">
    		<div class="col-md">
          <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Messages</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
            </li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">..1</div>
            <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">..2</div>
            <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">..3</div>
            <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">..4</div>
          </div>
 -->

		        <div class="tab-base">
		        	<ul class="nav nav-callout text-nowrap" id="myTab" style="flex-wrap: unset!important; overflow-x: auto; " role="tablist">
                <li class="nav-item d-block" role="presentation">
                    <button class="nav-link show active" data-bs-toggle="tab" data-bs-target="#studi_akhir" type="button" role="tab" aria-controls="home" >Studi Akhir</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#peserta" type="button" role="tab" aria-controls="peserta" >Data Mahasiswa <!-- <span class="badge bg-primary ms-2">0</span> --></button>

                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pembimbing" type="button" role="tab" aria-controls="pembimbing" >Dosen Pembimbing <!-- <span class="badge bg-primary ms-2">0</span> --></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#penguji" type="button" role="tab" aria-controls="penguji" >Dosen Penguji <!-- <span class="badge bg-primary ms-2">0</span> --></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link h-100" data-bs-toggle="tab" data-bs-target="#penjadwalan" type="button" role="tab" aria-controls="penjadwalan" >Penjadwalan <br><!-- <span class="badge bg-primary ms-2">0</span> --></button>
                </li>
              </ul>

	            <div class="tab-content" style="border-top-right-radius: 0!important;">
	            	<?php $this->load->view('studi_akhir/tab_studi_akhir'); ?>
                <?php $this->load->view('studi_akhir/tab_mahasiswa'); ?>
                <?php $this->load->view('studi_akhir/tab_pembimbing'); ?>
                <?php $this->load->view('studi_akhir/tab_penguji'); ?>
	            	<?php $this->load->view('studi_akhir/tab_penjadwalan'); ?>
				     </div>
		        </div>
    		</div>
    	</div>
    </div>
</div>

<datalist id="datalist_dosen">
  <?php foreach($dosen as $dosen): ?>
  <option value="<?= $dosen->nidn ?>"><?= $dosen->nm_sdm ?></option>
  <?php endforeach; ?>
</datalist>

<?php $this->load->view('studi_akhir/modal'); ?>

<script>
  function castvote(index) {
    document.querySelectorAll('#nidn').forEach( el => {
        var datalist = el;
        var browserChildren = document.querySelector('#datalist_dosen').children

        var flag = false
        for(let i = 0; i < browserChildren.length; i++){
            flag = browserChildren[i].value === datalist.value || flag
        }

        if (!flag)
          datalist.value = ""
    })
  }
  
  document.querySelectorAll('button[data-bs-toggle="tab"]').forEach( el => {
    el.addEventListener('show.bs.tab', function(event) {
        localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
      })
  })

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    var triggerEl = document.querySelector('#myTab li button[data-bs-target="'+activeTab+'"]')
    var tab = new bootstrap.Tab(triggerEl)
    document.addEventListener("DOMContentLoaded", function(event) {
    	tab.show()
	});
  }
</script>
