<?php if(isset($_GET['meet'])): ?>
<div class="content__boxed">
	<div class="content__wrap pb-0">
		<div class="row">
			<div class="col-md-12">
				<style>
					#jitsiConferenceFrame0 { border-radius: .4375rem }
				</style>
				<div id="meet"></div>
				<script src='https://meet.jit.si/external_api.js'></script>
				<script>
                    const domain = '<?= domain_jitsi($anggota->id_mahasiswa_pt) ?>';
					const options = {
					    roomName: `<?= $title ?>`,
					    width: '100%',
					    height: 500,
					    parentNode: document.querySelector('#meet'),
					    configOverwrite: { 
					    	startWithAudioMuted: true,
					    	startWithVideoMuted: true,
					    },
					 	// interfaceConfigOverwrite: { 
					  //   	TOOLBAR_BUTTONS: [
						 //        'closedcaptions', 'desktop', 'fullscreen',
						 //        'fodeviceselection', 'chat',
						 //        'raisehand',
						 //        'videoquality', 'shortcuts',
						 //        'tileview',
						 //    ]
					  //   },
					    userInfo: {
					        displayName: '<?= format_nama($_SESSION['nama_pengguna']) ?> (<?= strtoupper($title) ?>)'
					    }
					};
					const api = new JitsiMeetExternalAPI(domain, options);
					api.executeCommand('subject', 'BIMBINGAN SKRIPSI / TUGAS AKHIR')
					api.executeCommand('avatarUrl', '<?= $_SESSION['picture'] ?>');
					api.on('readyToClose', () => {
					     window.location.href = '<?= base_url($this->uri->uri_string()) ?>'
					});
				</script>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>