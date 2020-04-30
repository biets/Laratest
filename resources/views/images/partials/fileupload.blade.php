<div class="form-group">
    <label for="">Thumbnail</label>
    <input type="file" name="img_path" id="img_path" class="form-control" value="{{$photo->img_path}}" placeholder="Album thumb" />
</div>

@if($photo->img_path)
    <div class="form-group">
        <img src="{{asset($photo->path)}}" title="{{$photo->name}}" alt="{{$photo->name}}" height="200" width="200" />
    </div>
@endif
