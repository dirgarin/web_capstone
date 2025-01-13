@extends('layout.app')

@section('contents')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Buat Submission</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('submission.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" rows="10" id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="open" class="form-label">Open</label>
                                <input type="date" class="form-control @error('open') is-invalid @enderror"
                                    id="open" name="open" value="{{ old('open') }}">
                                @error('open')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline" name="deadline" value="{{ old('deadline') }}">
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
                                    <!-- Tempat segmen radio button -->
                                </div>
                                <button id="add-segment" type="button" class="btn btn-secondary mt-3">Add
                                    Penilaian</button>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Buat</button>
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
            let segmentCounter = 0;

            const addSegment = () => {
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
                bobot.placeholder = 'bobot';
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
                addRadioButton.addEventListener('click', () => addRadio(radioContainer, segmentCounter));

                segmentDiv.appendChild(radioContainer);
                segmentDiv.appendChild(addRadioButton);

                segmentsContainer.appendChild(segmentDiv);

                addRadio(radioContainer, segmentCounter);
            };

            const addRadio = (container, segmentIndex) => {
                const radioGroup = document.createElement('div');
                radioGroup.className = 'radio-group';

                const radioIndex = container.childElementCount;

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
                container.appendChild(radioGroup);
            };



            addSegment();

            addSegmentButton.addEventListener('click', addSegment);
        });
    </script>
@endsection
