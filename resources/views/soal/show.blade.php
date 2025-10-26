@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Latihan Soal">
<meta name="description" content="Latihan soal online dengan pembahasan dan analisis kemampuan belajar">
<meta name="keywords" content="Kelas Privat, latihan soal, soal online, pembahasan soal, analisis kemampuan">
<meta property="og:title" content="Kelas Privat - Latihan Soal">
<meta property="og:description" content="Latihan soal online dengan pembahasan dan analisis kemampuan belajar">
<meta property="og:site_name" content="Kelas Privat: Platform Pembelajaran Online">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $paket->name }}</h1>
            <p class="text-muted mb-0">
                {{ $paket->mapel }} - {{ $paket->jenjang }}
            </p>
        </div>
        <div class="d-flex align-items-center">
            <div class="me-3">
                <span class="badge bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-clock me-1"></i>
                    <span id="timer">00:00:00</span>
                </span>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exitModal">
                            <i class="fas fa-sign-out-alt me-2"></i>Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="fas fa-check me-1"></i>
                        <span id="answeredCount">0</span> Dijawab
                    </span>
                    <span class="badge bg-warning bg-opacity-10 text-warning me-2">
                        <i class="fas fa-flag me-1"></i>
                        <span id="flaggedCount">0</span> Ditandai
                    </span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                        <i class="fas fa-question me-1"></i>
                        <span id="unansweredCount">0</span> Belum Dijawab
                    </span>
                </div>
                <div class="text-muted small">
                    Sisa Waktu: <span id="remainingTime">00:00:00</span>
                </div>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progressBar"></div>
            </div>
        </div>
    </div>

    <!-- Question Navigation -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2" id="questionNav">
                @for($i = 0; $i < $allSoal->count(); $i++)
                    <button type="button"
                        class="btn btn-sm question-nav-btn {{ $i === (int)$currentIndex ? 'active' : '' }} {{ isset($answers[$i]) && $answers[$i] !== '' ? 'answered' : '' }} {{ isset($flagged[$i]) && $flagged[$i] ? 'flagged' : '' }}"
                        data-index="{{ $i }}" onclick="navigateToQuestion({{ $i }})">
                        {{ $i + 1 }}
                    </button>
                    @endfor
            </div>
        </div>
    </div>

    <!-- Question Container -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <form id="answerForm">
                @csrf
                <input type="hidden" name="paket" value="{{ $paket->id }}">
                <input type="hidden" name="index" value="{{ (int)$currentIndex }}">
                <input type="hidden" name="answers[{{ (int)$currentIndex }}]" id="selectedAnswer"
                    value="{{ isset($answers[(int)$currentIndex]) ? $answers[(int)$currentIndex] : '' }}">

                <!-- Question Number and Text -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            Soal {{ (int)$currentIndex + 1 }}
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-warning flag-btn"
                            data-index="{{ (int)$currentIndex }}"
                            data-flagged="{{ isset($flagged[(int)$currentIndex]) && $flagged[(int)$currentIndex] ? 'true' : 'false' }}">
                            <i class="fas fa-flag me-2"></i>
                            Tandai
                        </button>
                    </div>
                    <h3 class="h4 mb-3">{{ $soal->soal }}</h3>

                    @if($soal->image_soal)
                    <div class="mb-4">
                        <img src="{{ URL::To($soal->image_soal) }}" alt="Gambar Soal" class="img-fluid rounded"
                            style="max-height: 300px;" loading="lazy">
                    </div>
                    @endif
                </div>

                <!-- Answer Options -->
                <div class="mb-4">
                    @php
                    $options = [
                    'A' => ['text' => $soal->jawaban_a, 'image' => $soal->image_a],
                    'B' => ['text' => $soal->jawaban_b, 'image' => $soal->image_b],
                    'C' => ['text' => $soal->jawaban_c, 'image' => $soal->image_c],
                    'D' => ['text' => $soal->jawaban_d, 'image' => $soal->image_d],
                    'E' => ['text' => $soal->jawaban_e, 'image' => $soal->image_e]
                    ];
                    @endphp

                    @foreach($options as $key => $option)
                    <div class="form-check custom-option mb-3">
                        <input type="radio" name="answer_radio" value="{{ $key }}" id="answer_{{ $key }}"
                            class="form-check-input"
                            {{ isset($answers[(int)$currentIndex]) && $answers[(int)$currentIndex] == $key ? 'checked' : '' }}>
                        <label class="form-check-label w-100" for="answer_{{ $key }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-3">{{ $key }}</span>
                                        <span>{{ $option['text'] }}</span>
                                    </div>
                                    @if($option['image'])
                                    <div class="mt-2">
                                        <img src="{{ URL::To($option['image']) }}" alt="Gambar Jawaban"
                                            class="img-fluid rounded" style="max-height: 100px;" loading="lazy">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between">
                    @if((int)$currentIndex > 0)
                    <button type="button" class="btn btn-outline-primary"
                        onclick="navigateToQuestion({{ (int)$currentIndex - 1 }})">
                        <i class="fas fa-arrow-left me-2"></i>Soal Sebelumnya
                    </button>
                    @else
                    <div></div>
                    @endif

                    @if((int)$currentIndex < $allSoal->count() - 1)
                        <button type="button" class="btn btn-primary"
                            onclick="navigateToQuestion({{ (int)$currentIndex + 1 }})">
                            Soal Selanjutnya
                            <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-success" onclick="submitFinalAnswer()">
                            Simpan & Lihat Hasil
                            <i class="fas fa-check ms-2"></i>
                        </button>
                        @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Exit Confirmation Modal -->
<div class="modal fade" id="exitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin keluar? Progress Anda akan disimpan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('soal.index') }}" class="btn btn-primary">Ya, Keluar</a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .question-nav-btn {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
        transition: all 0.2s;
    }

    .question-nav-btn:hover {
        background-color: #e9ecef;
        border-color: #ced4da;
    }

    .question-nav-btn.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    .question-nav-btn.answered {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    .question-nav-btn.flagged {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .custom-option .form-check-input {
        display: none;
    }

    .custom-option .form-check-label {
        cursor: pointer;
    }

    .custom-option .form-check-input:checked+.form-check-label .card {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }

    .custom-option .card {
        transition: all 0.2s;
    }

    .custom-option .card:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Timer functionality
    let timeLeft = {{ (int)($paket->durasi ?? 60) }} * 60; // Convert minutes to seconds
    const timerDisplay = document.getElementById('timer');
    const remainingTimeDisplay = document.getElementById('remainingTime');
    
    function updateTimer() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        
        const timeString = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        timerDisplay.textContent = timeString;
        remainingTimeDisplay.textContent = timeString;
        
        if (timeLeft > 0) {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        } else {
            document.getElementById('finalAnswerForm').submit();
        }
    }
    
    updateTimer();
    
    // Store answers in memory
    let answers = {!! json_encode($answers) !!};
    let flagged = {!! json_encode($flagged) !!};
    let currentIndex = {{ (int)$currentIndex }};

    // Save answers to session periodically
    function saveToSession() {
        fetch('{{ route('save_temp_answers', ['id' => $paket->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answers: answers,
                flagged: flagged
            })
        });
    }

    // Save to session every 30 seconds
    setInterval(saveToSession, 30000);

    // Save to session when navigating away
    window.addEventListener('beforeunload', function(e) {
        saveToSession();
    });

    function navigateToQuestion(newIndex) {
        // Save current answer
        const selectedAnswer = document.querySelector('input[name="answer_radio"]:checked')?.value || '';
        answers[currentIndex] = selectedAnswer;
        
        // Save to session before navigating
        saveToSession();
        
        // Update current index
        currentIndex = newIndex;
        
        // Update UI
        updateQuestionNavigation();
        
        // Load new question via AJAX
        fetch('{{ route('goto_soal') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                paket: {{ $paket->id }},
                index: newIndex,
                answers: answers,
                flagged: flagged
            })
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update question content
            document.querySelector('.card-body.p-4').innerHTML = 
                doc.querySelector('.card-body.p-4').innerHTML;
            
            // Restore selected answer if exists
            if (answers[currentIndex]) {
                const radioInput = document.querySelector(`input[name="answer_radio"][value="${answers[currentIndex]}"]`);
                if (radioInput) {
                    radioInput.checked = true;
                }
            }
            
            // Update navigation buttons
            updateQuestionNavigation();
            
            // Update progress
            updateProgress();
        });
    }

    function submitFinalAnswer() {
        // Save current answer
        const selectedAnswer = document.querySelector('input[name="answer_radio"]:checked')?.value || '';
        answers[currentIndex] = selectedAnswer;
        
        // Submit final answers
        fetch(`{{ route('submit_answer', ['id' => $paket->id, 'index' => ':index']) }}`.replace(':index', currentIndex), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                answers: answers,
                flagged: flagged
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Terjadi kesalahan');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            } else {
                window.location.href = data.redirect;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
        });
    }

    function updateQuestionNavigation() {
        // Update active state
        document.querySelectorAll('.question-nav-btn').forEach(btn => {
            btn.classList.remove('active');
            const index = parseInt(btn.dataset.index);
            
            // Update answered state
            if (answers[index]) {
                btn.classList.add('answered');
            } else {
                btn.classList.remove('answered');
            }
            
            // Update flagged state
            if (flagged[index]) {
                btn.classList.add('flagged');
            } else {
                btn.classList.remove('flagged');
            }
        });
        
        // Set active state
        document.querySelector(`.question-nav-btn[data-index="${currentIndex}"]`)?.classList.add('active');
    }

    // Handle answer selection
    document.addEventListener('change', function(e) {
        if (e.target.matches('input[name="answer_radio"]')) {
            answers[currentIndex] = e.target.value;
            
            // Update UI
            const currentBtn = document.querySelector(`.question-nav-btn[data-index="${currentIndex}"]`);
            currentBtn.classList.add('answered');
            updateProgress();
        }
    });

    // Update progress bar
    function updateProgress() {
        const totalQuestions = {{ $allSoal->count() }};
        const answeredQuestions = Object.values(answers).filter(answer => answer !== '' && answer !== null).length;
        const flaggedQuestions = Object.values(flagged).filter(flag => flag).length;
        const unansweredQuestions = totalQuestions - answeredQuestions;

        document.getElementById('answeredCount').textContent = answeredQuestions;
        document.getElementById('flaggedCount').textContent = flaggedQuestions;
        document.getElementById('unansweredCount').textContent = unansweredQuestions;

        const progressPercentage = (answeredQuestions / totalQuestions) * 100;
        document.getElementById('progressBar').style.width = progressPercentage + '%';
    }

    // Handle flag button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.flag-btn')) {
            flagged[currentIndex] = !flagged[currentIndex];
            
            const currentBtn = document.querySelector(`.question-nav-btn[data-index="${currentIndex}"]`);
            currentBtn.classList.toggle('flagged');
            updateProgress();
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key >= '1' && e.key <= '5') {
            const option = String.fromCharCode(64 + parseInt(e.key)); // Convert 1-5 to A-E
            document.querySelector(`input[value="${option}"]`).checked = true;
        } else if (e.key === 'ArrowLeft' && {{ (int)$currentIndex }} > 0) {
            window.location.href = "{{ route('soal.show', ['id' => $paket->id, 'index' => (int)$currentIndex - 1]) }}";
        } else if (e.key === 'ArrowRight' && {{ (int)$currentIndex }} < {{ $allSoal->count() - 1 }}) {
            window.location.href = "{{ route('soal.show', ['id' => $paket->id, 'index' => (int)$currentIndex + 1]) }}";
        }
    });

    // Initialize progress
    updateProgress();
</script>
@endpush

@endsection