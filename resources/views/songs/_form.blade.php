<label for="title">Nama lagu *</label>
<input type="text" id="title" name="title" value="{{ old('title', $song->title) }}" required>
@error('title') <div class="error">{{ $message }}</div> @enderror

<label for="artist">Penyanyi *</label>
<input type="text" id="artist" name="artist" value="{{ old('artist', $song->artist) }}" required>
@error('artist') <div class="error">{{ $message }}</div> @enderror

<label for="tag1">Tag 1 *</label>
<input type="text" id="tag1" name="tag1" value="{{ old('tag1', $song->tag1) }}" required>
<div class="hint">Contoh: citypop, rock, calm</div>
@error('tag1') <div class="error">{{ $message }}</div> @enderror

<label for="tag2">Tag 2</label>
<input type="text" id="tag2" name="tag2" value="{{ old('tag2', $song->tag2) }}">
@error('tag2') <div class="error">{{ $message }}</div> @enderror

<label for="reference">Referensi</label>
<input type="text" id="reference" name="reference" value="{{ old('reference', $song->reference) }}">
<div class="hint">Anime, game, atau film asal lagu ini</div>
@error('reference') <div class="error">{{ $message }}</div> @enderror

<label for="link">Link</label>
<input type="url" id="link" name="link" value="{{ old('link', $song->link) }}" placeholder="https://...">
@error('link') <div class="error">{{ $message }}</div> @enderror
