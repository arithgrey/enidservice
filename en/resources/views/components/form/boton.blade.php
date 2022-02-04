<button {{ $attributes->class(['format_submit'])->merge(['type' => 'submit']) }}/>
    {{ $titulo ?? 'Enviar' }}
</button>
