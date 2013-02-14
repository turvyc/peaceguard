//
//  Report.h
//  PeaceGuard
//
//  Created by JonasYao on 2013-02-13.
//  Copyright (c) 2013 JonasYao. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Report : NSObject

@property (nonatomic, copy) NSString *title;
@property (nonatomic, copy) NSString *description;

-(id)initWithName:(NSString*)title description:(NSString *) description;

@end
