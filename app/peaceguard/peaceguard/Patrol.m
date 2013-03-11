//
//  Patrol.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "Patrol.h"

@implementation Patrol

//Custon initializer
-(id)initWithTime
{
    self = [super init];
    if (self){
        NSDate *date = [NSDate date];
        NSTimeInterval timeInterval = [date timeIntervalSince1970];
        _time = timeInterval;
        _patrolID = nil;
        _route = nil;
        _duration = 0;
        _distance = 0;
        return self;
    }
    return nil;
}

@end
