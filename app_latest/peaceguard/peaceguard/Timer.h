//
//  Timer.h
//  peaceguard
//
//  Created by JonasYao on 2013-03-12.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Timer : NSObject {
    NSDate *start;
    NSDate *end;
}

- (void) startTimer;
- (void) stopTimer;
- (double) timeElapsedInSeconds;
- (double) timeElapsedInMilliseconds;
- (double) timeElapsedInMinutes;

@end
