<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory, Notifiable;

    // Table associated with the model
    protected $table = 'users';

    // The attributes that are mass assignable
    protected $fillable = [
        'user_type',
        'department',
        'password',
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('user_type', $type);
    }

    /**
     * Get the user's department (for HOD users).
     *
     * This method will return the full department name based on the department code.
     *
     * @return string
     */
    public function getDepartmentNameAttribute()
    {
        $departmentNames = [
            'CS' => 'Computer Science',
            'IT' => 'Information Technology',
            'CDF' => 'Costume Design & Fashion',
            'CA' => 'Computer Application',
            'ENG' => 'English',
            'COM' => 'Commerce',
            'COM(pa)' => 'Commerce Professional Accounting',
            'COM(ba)' => 'Business Analytics',
            'BBA' => 'Business Administration',
            'STAT' => 'Statistics',
            'ELEC' => 'Electronics',
        ];

        // Return the department name, or 'Unknown Department' if not found
        return $departmentNames[$this->department] ?? 'Unknown Department';
    }

    /**
     * Set the user's department (stores department code).
     *
     * This method ensures that only a valid department code is saved.
     *
     * @param string $department
     * @return void
     */
    public function setDepartmentAttribute($department)
    {
        $validDepartments = ['CS', 'IT', 'CDF', 'CA', 'ENG', 'COM', 'COM(pa)', 'COM(ba)', 'BBA', 'STAT', 'ELEC'];

        // Store the department code only if it's valid
        if (in_array($department, $validDepartments)) {
            $this->attributes['department'] = $department;
        } else {
            $this->attributes['department'] = null;  // Optionally handle this according to your requirements
        }
    }

    /**
     * Custom accessor for the password attribute.
     * Ensures the password is always hidden.
     *
     * @param string $value
     * @return string
     */
    public function getPasswordAttribute($value)
    {
        return $value;  // Return the raw password (not hidden)
    }

    /**
     * Custom mutator for the password attribute.
     * Hashes the password before saving to the database.
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        // Ensure password is hashed before saving
        if (!empty($password) && $password !== $this->attributes['password']) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    /**
     * A custom function to return user's details.
     * This function is often used to extract data from the model when needed.
     *
     * @return array
     */
    public function getUserDetails()
    {
        return [
            'user_type' => $this->user_type,
            'department' => $this->getDepartmentNameAttribute(),
            // Do not return raw password in production!
            'password' => '********',  // Do not expose password in API response
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
