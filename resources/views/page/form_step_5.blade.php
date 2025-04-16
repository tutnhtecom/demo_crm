{{-- <form id="myForm5" class="col-12" method="POST" action="" data-step="5"> --}}
<form id="myForm5" class="col-12" method="POST" action="" data-step="5" style="display:none;">
    @csrf
    <h5 class="text-18 mb-4"> Thông tin xét tuyển </h5>
    <h5 class="text-16 mb-2"> Chọn bậc/ Hệ xét tuyển </h5>
    <div class="row mb-3">
        <div class="col-12 date-input-container">
            <div class="radio-input-container">
                <div class="radio-input-wrapper d-flex gap-4">
                    <div class="radio">
                        <input id="radio-1 admission-system" name="admission-system" type="radio" value="1" checked>
                        <label for="radio-1" class="radio-label">Đào tạo trực tuyến</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 35px"></div>

    <h5 class="text-16 mb-2"> Phương thức xét tuyển </h5>
    <div class="row mb-3">
        <div class="col-12 radio-input-container">
            <div class="radio-input-container">
                <div class="radio-input-wrapper d-flex gap-4">
                    @php $count_method = 1 @endphp
                    @foreach ($method_adminssions as $method)
                        <div class="radio radio-{{$count_method}}">
                            <input class="admission-method-radio" id="radio-f5-{{$count_method}}" name="admission-method" type="radio" value="{{$method->id}}" {{ $loop->first ? 'checked' : '' }} data-count="{{$count_method}}" >
                            <label for="radio-f5-{{$count_method}}" class="radio-label"> {{$method->name}} </label>
                        </div>
                        @php $count_method++ @endphp
                    @endforeach
                    {{-- <div class="radio radio-2">
                        <input id="radio-2-f5" name="admission-method" type="radio" value="1" checked>
                        <label for="radio-2-f5" class="radio-label">Văn bằng 1</label>
                    </div>
                    <div class="radio radio-3">
                        <input id="radio-3-f5" name="admission-method" type="radio" value="2">
                        <label for="radio-3-f5" class="radio-label">Văn bằng 2</label>
                    </div>
                    <div class="radio radio-3">
                        <input id="radio-4-f5" name="admission-method" type="radio" value="3">
                        <label for="radio-4-f5" class="radio-label">Liên thông</label>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 35px"></div>

    <div class="row">
        <div class="col-12">
            <div id="school-records-content" class="school-records-content">
                {{-- <div class="school-records-content-title">
                    <p class="text-14" style='font-weight:500'> Thông tin học bạ </p>
                </div> --}}
                <div class="school-records-content-info">
                    {{-- <div class="row mb-3">
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tỉnh/ Thành phố <span class="required">&#42;</span>
                            </label>
                            <div id="provinces_name_f5_1_wrapper" class="select-input-wrapper">
                                <select name="" id="provinces_name_f5_1" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-6 text-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tên Trường <span class="required">&#42;</span>
                            </label>
                            <div id="school_name_1_wrapper" class="text-input-wrapper">
                                <input type="text" placeholder="Nhập tên trường" id="school_name_1" class="text-input-custome col-12">
                                <p class="error-input"></p>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row mb-3">
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Ngành học đăng ký xét tuyển <span class="required">&#42;</span>
                            </label>
                            <div id="marjor_f5_1_wrapper" class="select-input-wrapper">
                                <select name="" id="marjor_f5_1" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($marjors as $marjor)
                                        <option value="{{ $marjor->id }}">{{ $marjor->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tổ hợp môn <span class="required">&#42;</span>
                            </label>
                            <div id="block_adminssions_wrapper" class="select-input-wrapper">
                                <select name="" id="block_adminssions" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($block_adminssions as $block_adminssion)
                                        <option data-id-major="{{ $block_adminssion['marjors_id'] }}" value="{{ $block_adminssion['id'] }}" data-mons="{{ $block_adminssion['subject'] }}">{{ $block_adminssion['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom: 35px"></div>

                    <p class="text-14" style='font-weight:500'> Nhập điểm trung bình các môn trong tổ hợp môn xét tuyển
                    </p>
                    <div class="row">
                        <div class="d-flex" style="gap:10px;margin-bottom:10px;">
                            <div class="box-1 text-14 text-w-500"> Môn </div>
                            <div class="box-2 text-14 text-w-500 subject">  </div>
                            <div class="box-2 text-14 text-w-500 subject">  </div>
                            <div class="box-2 text-14 text-w-500 subject">  </div>
                        </div>
                        <div class="d-flex" style="gap:10px;margin-bottom:10px;">
                            <div class="box-1 text-14 text-w-500"> Lớp 12 </div>
                            <input id="score-1" type="number" step="0.1" class="box-2 bg-white" placeholder="10" min="0">
                            <input id="score-2" type="number" step="0.1" class="box-2 bg-white" placeholder="10">
                            <input id="score-3" type="number" step="0.1" class="box-2 bg-white" placeholder="10">
                        </div>
                        {{-- <div class="d-flex" style="gap:10px;margin-bottom:10px;">
                            <div class="box-1 text-14 text-w-500"> Điểm trung bình </div>
                            <div class="box-2"> <span class="average-score text-14">10.00</span> </div>
                            <div class="box-2"> <span class="average-score text-14">10.00</span> </div>
                            <div class="box-2"> <span class="average-score text-14">10.00</span> </div>
                        </div> --}}
                        <div class="d-flex" style="gap:10px;margin-bottom:10px;">
                            <div class="box-3 d-flex justify-content-between">
                                <span class="text-14 text-w-500"> Tổng điểm </span>
                                <span class="total-score"> 30.00 </span>
                            </div>
                        </div>
                        <p id="score-error-1" class="error-input"></p>
                        <p id="score-error-2" class="error-input"></p>
                        <p id="score-error-3" class="error-input"></p>
                    </div>
                </div>
            </div>

            <div id="school-scoreboard-content" class="school-scoreboard-content">
                {{-- <div class="school-scoreboard-content-title">
                    <p class="text-14" style='font-weight:500'> Thông tin bảng điểm (Văn bằng 2) </p>
                </div> --}}
                <div class="school-scoreboard-content-info">
                    {{-- <div class="row mb-3">
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tỉnh/ Thành phố <span class="required">&#42;</span>
                            </label>
                            <div id="provinces_name_f5_2_wrapper" class="select-input-wrapper">
                                <select name="" id="provinces_name_f5_2" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-6 text-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tên Trường <span class="required">&#42;</span>
                            </label>
                            <div id="school_name_2_wrapper" class="text-input-wrapper">
                                <input type="text" placeholder="Nhập tên trường" id="school_name_2" class="text-input-custome col-12">
                                <p class="error-input"></p>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row mb-3">
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Ngành học đăng ký xét tuyển <span class="required">&#42;</span>
                            </label>
                            <div id="marjor_f5_2_wrapper" class="select-input-wrapper">
                                <select name="" id="marjor_f5_2" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($marjors as $marjor)
                                        <option value="{{ $marjor->id }}">{{ $marjor->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-6 text-input-container">
                            <div class="row">
                                <div class="col-6 select-input-container">
                                    <label for="" class="mb-2 date-label text-14">
                                        Chọn hệ số <span class="required">&#42;</span>
                                    </label>
                                    <div id="point_gpa_2_wrapper" class="text-input-wrapper">
                                        <select name="" id="point_gpa_2" class="col-12">
                                            <option value="">_Chọn_</option>
                                            <option value="4">Hệ số 4</option>
                                            <option value="10">Hệ số 10</option>
                                        </select>
                                        <p class="error-input"></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="" class="mb-2 date-label text-14">
                                        Điểm trung bình tốt nghiệp <span class="required">&#42;</span>
                                    </label>
                                    <div id="average_score_2_wrapper" class="text-input-wrapper">
                                        <input class="text-input-custome col-12" type="text" id="average_score_2"
                                            placeholder="Nhập" aria-label="" maxlength="4"/>
                                        <p class="error-input"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="articulation" class="school-scoreboard-content">
                {{-- <div class="school-scoreboard-content-title">
                    <p class="text-14" style='font-weight:500'> Thông tin bảng điểm (Liên thông) </p>
                </div> --}}
                <div class="school-scoreboard-content-info">
                    {{-- <div class="row mb-3">
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tỉnh/ Thành phố <span class="required">&#42;</span>
                            </label>
                            <div id="provinces_name_f5_3_wrapper" class="select-input-wrapper">
                                <select name="" id="provinces_name_f5_3" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-6 text-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Tên Trường <span class="required">&#42;</span>
                            </label>
                            <div id="school_name_3_wrapper" class="text-input-wrapper">
                                <input type="text" placeholder="Nhập tên trường" id="school_name_3" class="text-input-custome col-12">
                                <p class="error-input"></p>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row mb-3">
                        <div class="col-6 select-input-container">
                            <label for="" class="mb-2 select-label text-14">
                                Ngành học đăng ký xét tuyển <span class="required">&#42;</span>
                            </label>
                            <div id="marjor_f5_3_wrapper" class="select-input-wrapper">
                                <select name="" id="marjor_f5_3" class="col-12">
                                    <option value="">_Chọn_</option>
                                    @foreach($marjors as $marjor)
                                        <option value="{{ $marjor->id }}">{{ $marjor->name }}</option>
                                    @endforeach
                                </select>
                                <p class="error-input"></p>
                            </div>
                        </div>
                        <div class="col-6 text-input-container">
                            <div class="row">
                                <div class="col-6 select-input-container">
                                    <label for="" class="mb-2 date-label text-14">
                                        Chọn hệ số <span class="required">&#42;</span>
                                    </label>
                                    <div id="point_gpa_3_wrapper" class="text-input-wrapper">
                                        <select name="" id="point_gpa_3" class="col-12">
                                            <option value="">_Chọn_</option>
                                            <option value="4">Hệ số 4</option>
                                            <option value="10">Hệ số 10</option>
                                        </select>
                                        <p class="error-input"></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="" class="mb-2 date-label text-14">
                                        Điểm trung bình tốt nghiệp <span class="required">&#42;</span>
                                    </label>
                                    <div id="average_score_3_wrapper" class="text-input-wrapper">
                                        <input class="text-input-custome col-12" type="text" id="average_score_3"
                                            placeholder="Nhập" aria-label="" maxlength="4"/>
                                        <p class="error-input"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 150px"></div>
    <div class="row">
        <div class="col-12 d-flex gap-3 justify-content-end">
            <button type="button" id="prevStep5" class="button-custome-back">
                <span>&#10140;</span> Quay lại
            </button>
            <button type="submit" class="button-custome-next">
                Tiếp theo <span>&#10140;</span>
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        function toggleContent(count) {
            $("#school-records-content, #school-scoreboard-content, #articulation").hide(); // Ẩn tất cả trước

            if (count == 1) {
                $("#school-records-content").show();
            } else if (count == 2) {
                $("#school-scoreboard-content").show();
            } else if (count == 3) {
                $("#articulation").show();
            }
        }

        // Mặc định khi trang tải xong
        toggleContent($("input[name='admission-method']:checked").data("count"));

        // Khi người dùng chọn radio khác
        $(".admission-method-radio").change(function() {
            toggleContent($(this).data("count"));
        });
    });
</script>
