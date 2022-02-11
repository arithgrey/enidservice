<button {{ $attributes->class(['format_submit w-full'])->merge(['type' => 'submit']) }}/>
    {{ $titulo ?? 'Enviar' }}
</button>
