@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Submission</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('submission.update', $submission->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Menambahkan metode PUT untuk update -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul', $submission->judul) }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" rows="10" id="deskripsi" name="deskripsi">{{ old('deskripsi', $submission->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="open" class="form-label">Open</label>
                                <input type="date" class="form-control @error('open') is-invalid @enderror"
                                    id="open" name="open" value="{{ old('open', $submission->open) }}">
                                @error('open')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline" name="deadline" value="{{ old('deadline', $submission->deadline) }}">
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">File</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file" accept=".doc,.docx,.pdf">
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="disini">
                                <label for="">Penilaian</label>
                                <div id="segments-container">
                                    @foreach($submission->penilaian as $i => $penilaian)
                                        <div class="segment my-3" id="segment-{{ $loop->index }}">
                                            <input type="text" class="form-control" name="segments[{{ $i }}][description]" value="{{ old('segments.' . $i . '.description', $penilaian->text) }}" style="margin-bottom: 10px;">
                                            <input type="number" class="form-control" name="segments[{{ $i }}][bobot]" value="{{ old('segments.' . $i . '.bobot', $penilaian->bobot) }}" style="margin-bottom: 10px; width: 20%;" placeholder="Bobot">

                                            <div class="radio-container">
                                                @foreach($penilaian->choices as $choice)
                                                    <div class="radio-group">
                                                        <input type="radio" name="segments[{{ $i }}][data][{{ $loop->iteration }}][values]" value="{{ old('segments.' . $i . '.data.' . $loop->iteration . '.values', $choice->text) }}">
                                                        <input type="text" class="form-control" name="segments[{{ $i }}][data][{{ $loop->iteration }}][values]" value="{{ old('segments.' . $i . '.data.' . $loop->iteration . '.values', $choice->text) }}" style="width: 50%; display: inline;">
                                                        <input type="file" name="segments[{{ $i }}][data][{{ $loop->iteration }}][files]" value="{{ old('segments.' . $i . '.data.' . $loop->iteration . '.files', $choice->image) }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="btn btn-primary mt-3" type="button" onclick="addRadio({{ $i }}, this)">Add Nilai</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button id="add-segment" type="button" class="btn btn-secondary mt-3">Add Penilaian</button>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const segmentsContainer = document.getElementById('segments-container');
    const addSegmentButton = document.getElementById('add-segment');
    let segmentCounter = document.querySelectorAll('div.segment').length;

    // Fungsi untuk menambahkan radio button dan input lainnya
    window.addRadio = (segmentIndex, buttonElement) => {
        const radioContainer = buttonElement.previousElementSibling;
        const radioGroup = document.createElement('div');
        radioGroup.className = 'radio-group';

        const radioIndex = radioContainer.childElementCount+1;

        // Radio button (hanya hiasan)
        const radioButton = document.createElement('input');
        radioButton.type = 'radio';

        // Input text
        const inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.className = 'form-control ml-3';
        inputText.style.display = 'inline';
        inputText.style.width = '50%';
        inputText.placeholder = '';
        inputText.name = `segments[${segmentIndex}][data][${radioIndex}][values]`;

        // Input file
        const inputFile = document.createElement('input');
        inputFile.type = 'file';
        inputFile.name = `segments[${segmentIndex}][data][${radioIndex}][files]`;

        radioGroup.appendChild(radioButton);
        radioGroup.appendChild(inputText);
        radioGroup.appendChild(inputFile);
        radioContainer.appendChild(radioGroup);
    }

    // Fungsi untuk menambahkan segment baru
    function addSegment() {
        segmentCounter++;
        const segmentDiv = document.createElement('div');
        segmentDiv.className = 'segment';
        segmentDiv.id = `segment-${segmentCounter}`;

        // Input untuk deskripsi segment
        const segmentInput = document.createElement('input');
        segmentInput.type = 'text';
        segmentInput.className = 'form-control';
        segmentInput.placeholder = '';
        segmentInput.name = `segments[${segmentCounter}][description]`;
        segmentInput.style.display = 'block';
        segmentInput.style.marginBottom = '10px';
        segmentDiv.appendChild(segmentInput);

        const bobot = document.createElement('input');
        bobot.type = 'number';
        bobot.className = 'form-control';
        bobot.placeholder = 'Bobot';
        bobot.name = `segments[${segmentCounter}][bobot]`;
        bobot.style.display = 'block';
        bobot.style.width = '20%';
        bobot.style.marginBottom = '10px';
        segmentDiv.appendChild(bobot);

        const radioContainer = document.createElement('div');
        radioContainer.className = 'radio-container';

        const addRadioButton = document.createElement('button');
        addRadioButton.textContent = 'Add Nilai';
        addRadioButton.type = 'button';
        addRadioButton.className = 'btn btn-primary mt-3';

        // Gunakan onclick untuk memanggil addRadio dengan parameter
        addRadioButton.setAttribute('onclick', `addRadio(${segmentCounter}, this)`);

        segmentDiv.appendChild(radioContainer);
        segmentDiv.appendChild(addRadioButton);

        segmentsContainer.appendChild(segmentDiv);

        // Menambahkan radio button pertama kali saat segment dibuat
        addRadio(segmentCounter, addRadioButton);
    }

    // Event listener untuk tombol add segment
    addSegmentButton.addEventListener('click', addSegment);
});



    </script>
@endsection
