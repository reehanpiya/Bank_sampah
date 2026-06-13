class HargaSampah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'harga_sampah';

    protected $fillable = [
        'jenis_sampah_id',
        'harga',
        'tanggal_berlaku',
        'tanggal_berakhir',
        'status_aktif',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'tanggal_berlaku' => 'date',
            'tanggal_berakhir' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    public function jenisSampah(): BelongsTo
    {
        return $this->belongsTo(JenisSampah::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}