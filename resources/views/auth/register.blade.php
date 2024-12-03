<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registration</title>
    <link rel="stylesheet" href="css/register.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  </head>
  <body>
    @include('components.notifikasi-action')

    <div class="container">
      <div class="login-link">
        <div class="logo">
          <img src="assets/images/klhk.png" alt="klhk" />
        </div>
        <p class="side-big-heading">Sudah memiliki Akun?</p>
        <a href="{{ route('login') }}" class="loginbtn">Login</a>

      </div>
      
      <div class="signup-form-container">
        <p class="big-heading">Membuat Akun</p>
        <div class="progress-bar">
            <div class="stage">
              <p class="tool-tip">Informasi Pribadi</p>
              <p class="stageno stageno-1">1</p>
            </div>
            <div class="stage">
              <p class="tool-tip">Alamat Lengkap</p>
              <p class="stageno stageno-2">2</p>
            </div>
            <div class="stage">
              <p class="tool-tip">Buat Akun</p>
              <p class="stageno stageno-3">3</p>
          </div>
        </div>
        
        <div id="validation-errors" class="mb-4">
          
        </div>
        <br>


        <div class="signup-form-content">
          <form id="stage1" action="{{ route('register1') }}"  method="POST">
              @csrf
              <div class="stage1-content">
                  <div class="button-container">
                    <div class="text-fields name">
                      <label for="nama_lengkap">Nama Lengkap</label>
                      <input type="text" name="nama_lengkap" id="nama_lengkap" 
                             placeholder="Nama lengkap Anda" required 
                             pattern="[A-Za-z\s]+" 
                             title="Nama hanya boleh mengandung huruf alfabet dan spasi" />
                  </div>
                      <div class="gender-selection">
                          <p class="field-heading">Jenis Kelamin :</p>
                          <label for="jenis_kelamin_laki-laki"> <input type="radio" name="jenis_kelamin" value="1" {{ old('jenis_kelamin') == '1' ? 'checked' : '' }} id="jenis_kelamin_laki-laki" required/> Laki-Laki </label>
                          <label for="jenis_kelamin_perempuan"> <input type="radio" name="jenis_kelamin" value="0" {{ old('jenis_kelamin') == '0' ? 'checked' : '' }} id="jenis_kelamin_perempuan" required/> Perempuan</label>
                      </div>
                  </div>
                  <div class="button-container">
                      <div class="text-fields nip">
                        <label for="nip">NIP</label>
                        <input type="text" name="nip" id="nip" 
                              pattern="^[0-9]{18}$" 
                              placeholder="Isi dengan Angka" 
                              required 
                              title="Hanya boleh angka saja dan berjumlah 18 digit" 
                              maxlength="18"
                              oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                      </div>
                      <div class="text-fields nomor_telepon">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon"
                               oninput='this.value=this.value.replace(/[^0-9]/g,"")' 
                               placeholder="628123456789"
                               pattern="^62[0-9]{9,11}$" 
                               required title="Harus diawali dengan 62 dan terdiri dari 11 hingga 13 digit!" 
                               maxlength="13"/>
                    </div>
                      <div class="text-fields bidang">
                          <label for="id_role">Bidang</label>
                          <select id="id_role" class="option-input" name="id_role" required autofocus>
                              <option value="" hidden>Pilih Bidang</option>
                              @foreach($roles as $role)
                                  <option id="{{ $role->tag }}"  value="{{ $role->id }}" required>{{ $role->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="text-fields bentuk_upt" >
                    <label for="bentuk_upt">Pilih Jenis UPT</label>
                          <select id="bentuk_upt" class="option-input" name="bentuk_upt"  autofocus>
                              <option value="" hidden>BBKSDA/BKSDA</option>
                              @foreach($upt_bentuk as $upt)
                                  <option id="{{ $upt->bentuk }}" value="{{ $upt->bentuk }}" >{{ $upt->bentuk }}</option>
                              @endforeach
                          </select>
                  </div>
                  <div class="text-fields wilayah_upt" >
                  <label for="wilayah_upt" >Pilih Wilayah UPT </label>
                          <select id="wilayah_upt" class="option-input upt-wilayah" name="wilayah_upt"  autofocus>
                              <option value="" hidden>Pilih Wilayah</option>
                              @foreach($upt_wilayah as $upt)
                                  <option id="{{ $upt->wilayah }}" value="{{ $upt->wilayah }}" >{{ $upt->wilayah }}</option>
                              @endforeach
                          </select>
                  </div>
                      <div class="text-fields id_lk" >
                          <label for="id_lk" >Unit Lembaga Konservasi</label>
                          <select id="id_lk" class="option-input id_lk" name="id_lk"  autofocus>
                              <option value="" hidden>Pilih Unit</option>
                              @foreach($list_lk as $lk)
                                  <option id="{{ $lk->slug }}" value="{{ $lk->id }}" >{{ $lk->nama }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="text-fields id_spesies" >
                          <label for="id_spesies" >Species</label>
                          <select id="id_spesies" class="option-input id_spesies" name="id_spesies"  autofocus>
                              <option value="" hidden>Pilih Species</option>
                              @foreach($list_species as $species)
                                  <option id="{{ $species->spesies }}" value="{{ $species->id }}" >{{ $species->spesies }}</option>
                              @endforeach
                          </select>
                      </div>
                  <div class="pagination-btns">
                  <input id="submitStage1" type="submit" value="Next" class="nextPage stagebtn1b"  />
                  </div>
              </div>
          </form>
          <form id="stage2" action="{{ route('register2') }}" method="POST">
            @csrf
              <div class="stage2-content">
              <div class="button-container">
                <div class="text-fields kodepos">
                  <label for="kodepos">Kode Pos</label>
                  <input type="text" name="kodepos" id="kodepos" 
                         placeholder="Isi Kode Pos Anda (5 digit)" 
                         required 
                         pattern="^[0-9]{5}$" 
                         title="Hanya boleh angka dan berjumlah 5 digit" 
                         maxlength="5"
                         oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                </div>
                <div class="text-fields provinsi">
                  <label for="provinsi">Provinsi</label>
                  <input type="text" name="provinsi" id="provinsi" placeholder="Isi Kode Pos"readonly />
                </div>
              </div>
              <div class="button-container">
                <div class="text-fields kota_kab">
                  <label for="kota_kab">Kota/Kabupaten</label>
                  <input type="text" name="kota_kab" id="kota_kab" placeholder="Isi Kode Pos" readonly />
                </div>
                <div class="text-fields kecamatan">
                  <label for="kecamatan">Kecamatan</label>
                  <input type="text" name="kecamatan" id="kecamatan" placeholder="Isi Kode Pos"readonly />
                </div>
              </div>
              <div class="button-container">
                <div class="text-fields kelurahan">
                  <label for="kelurahan">Kelurahan</label>
                  <input type="text" name="kelurahan" id="kelurahan" placeholder="Isi Kode Pos" readonly />
                </div>
                <div class="text-fields alamat_lengkap">
                  <label for="alamat_lengkap">Alamat Lengkap</label>
                  <input type="text" name="alamat_lengkap" id="alamat_lengkap" placeholder="Alamat Lengkap" required/>
                </div>
              </div>
              <div class="pagination-btns">
              <input type="button" value="Previous" class="previousPage stagebtn3a" onclick="stage2to1()" />
                <input id="submitStage2" type="submit" value="Next" class="nextPage stagebtn2b"  />
              </div>
            </div>
          </form>
          <form id="stage3" action="{{ route('register3') }}" method="POST">
          @csrf
          <div class="stage3-content">
            <div class="button-container">
                <div class="text-fields username">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Buat Username Anda" required/>
                </div>
              </div>
              <div class="button-container">
                <div class="text-fields email">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" 
                         placeholder="abcd@gmail.com" 
                         required 
                         pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z]+(\.[a-zA-Z]{2,})+" 
                         title="Format email tidak valid. Harus memiliki huruf setelah '@' dan diikuti oleh '.'" />
                </div>
              </div>

            <div class="button-container">
              <div class="text-fields password">
                  <label for="password">Password</label>
                  <div class="input-wrapper">
                      <input type="password" id="password" name="password" required placeholder="Password">
                      <span onclick="togglePasswordVisibility('password', this)" class="toggle-password"
                            data-show="{{ asset('assets/images/others/eye-show-password.png') }}"
                            data-hide="{{ asset('assets/images/others/eye-hide-password.png') }}">
                          <img src="{{ asset('assets/images/others/eye-hide-password.png') }}" alt="hide password" />
                      </span>
                  </div>
              </div>
          
              <div class="text-fields password_confirmation">
                  <label for="password_confirmation">Konfirmasi Password</label>
                  <div class="input-wrapper">
                      <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi Password">
                      <span onclick="togglePasswordVisibility('password_confirmation', this)" class="toggle-password"
                            data-show="{{ asset('assets/images/others/eye-show-password.png') }}"
                            data-hide="{{ asset('assets/images/others/eye-hide-password.png') }}">
                          <img src="{{ asset('assets/images/others/eye-hide-password.png') }}" alt="hide password" />
                      </span>
                  </div>
              </div>
          {{-- </div> --}}
          </div>         

              <div class="pagination-btns">
                <input type="button" value="Previous"  class="previousPage stagebtn3a" onclick="stage3to2()" />
              <input type="submit" value="Submit" class="nextPage stagebtn3b" />
              </div>              
          </div>
          
        </form>
      </div>
      
        
          

    </div>
    </div>

  </body>
  <script src="js/register.js"></script>
  <!-- <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script> -->
</html>