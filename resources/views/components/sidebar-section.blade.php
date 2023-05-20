<li class="mb-4">
    <div class="btn btn-toggle d-inline-flex align-items-center text-start rounded border-0 collapsed"
         data-bs-toggle="collapse"
         data-bs-target="#{{ $sectionid }}"
         aria-expanded="{{ $collapsed ? 'false' : 'true' }}">
        <span class="ms-2" style="color: black">{{ $title }}</span>
    </div>
    <div class="collapse{{ $collapsed ? '' : ' show' }}" id="{{ $sectionid }}">
        {{ $slot }}
    </div>
</li>
