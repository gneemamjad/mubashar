<?php

namespace App\Repository;

use App\Models\Reel;

class ReelRepository
{
    
    public function getAdById($id)
    {
        return Reel::where('id',$id)->first();
    }

    public function getWithRelations()
    {
        return Reel::with(['owner', 'ad'])
        ->select('reels.*')
        ->when(request()->has('search') && $searchValue = request('search')['value'], function($query) use ($searchValue) {
            $searchValue = strtolower($searchValue);
             $query->where(function ($q) use ($searchValue) {
                $q->whereRaw('LOWER(description) LIKE ?', ["%{$searchValue}%"]);
            });
        })
        ;
    }

    public function getReels()
    {
        return Reel::with(['owner', 'ad'])
            ->withCount('likes')
            ->with(['likes' => fn($q) => $q->where('user_id', auth()->id())])
            ->where('status', Reel::STATUS['APPROVED'])
            // ->where('id', 53)
            ->orderBy('id', 'desc')
            ->paginate(PAGINITION_PER_PAGE);
    }
    public function getReelsPerUser($userId)
    {
        return Reel::with(['owner', 'ad'])
            ->withCount('likes')
            ->with(['likes' => fn($q) => $q->where('user_id', auth()->id())])
            ->where('status', Reel::STATUS['APPROVED'])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(PAGINITION_PER_PAGE);
    }
    
    public function toggleLike($reel)
    {
        $userId = auth()->id();

        $existingLike = $reel->likes()
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return ['liked' => false];
        } else {
            $reel->likes()->create([
                'user_id' => $userId
            ]);
            return ['liked' => true];
        }
    }

    public function createReel(array $data)
    {
        return Reel::create([
            'ad_id' => $data['ad_id'],
            'user_id' => auth()->id(),
            'reel' => $data['media'],
            'description' => $data['description'],
            'status' => Reel::STATUS['PENDING']
        ]);
    }

        public function createReelFromAdmin(array $data)
    {
        return Reel::create([
            'ad_id' => $data['ad_id'],
            'user_id' => $data['user_id'],
            'reel' => $data['media'],
            'description' => $data['description'],
            'status' => Reel::STATUS['PENDING']
        ]);
    }

    public function updateStatus($id)
    {
        $reel = Reel::where('id', $id)->first();
        if($reel->status == 1) {
            $status = 2;
        } else {
            $status = 1;
        }
        return $reel->update(['status' => $status]);
    }
    
    function updateReel($reel, $adData)
    {
        return $reel->update($adData);
    }
    public function delete($id)
    {
        $reel = Reel::where('id', $id)->first();
        return $reel->delete();
    }

    
    function getApprovedAdByUserId($userId)
    {
        return Reel::query()->approved()->where('user_id',$userId)->orderBy('id', 'desc')->paginate(PAGINITION_PER_PAGE);
    }

    function getNotApprovedAdByUserId($userId)
    {
        return Reel::query()->notApproved()->where('user_id',$userId)->orderBy('id', 'desc')->paginate(PAGINITION_PER_PAGE);
    }

    function getPendingAdByUserId($userId)
    {
        return Reel::query()->pending()->where('user_id',$userId)->orderBy('id', 'desc')->paginate(PAGINITION_PER_PAGE);
    }
    
    function getUserReelsDetailsMetrics($userId)
    {
        $reelInfo = Reel::query()
            ->selectRaw("
                COALESCE(SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END), 0) AS approved,
                COALESCE(SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END), 0) AS not_approved,
                COALESCE(SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END), 0) AS pending
            ")
            ->where('user_id', $userId)
            ->first();

        $reelInfo = [
            'approved' => (int) $reelInfo->approved,
            'not_approved' => (int) $reelInfo->not_approved,
            'pending' => (int) $reelInfo->pending,
        ];
        return $reelInfo;
    }
}
